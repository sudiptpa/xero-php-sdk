#!/usr/bin/env python3
"""Schema field audit: SDK model fields vs Xero OpenAPI component schemas.

For each PHP model with a getDefinitions() body, picks the best-matching
schema in that model's API spec and reports four classes of drift:

  GUESSED - the field name appears in no schema of the spec (invented)
  CASE    - matches a schema property case-insensitively but casing differs
  TYPE    - matches exactly but the Field type disagrees with the schema type
  MISSING - a spec property is absent from the model (exact schema match only)

Exits 1 if any findings are reported. Zero tolerance — no exceptions.

Specs are read from the directory in the XERO_SPECS_DIR environment variable,
defaulting to ../../openapi relative to this script (the local working copy).
"""
import os
import re
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
SRC_DIR = os.path.join(HERE, "..", "..", "src")
SPECS_DIR = os.environ.get("XERO_SPECS_DIR", os.path.join(HERE, "..", "..", "openapi"))

PATH_TO_SPEC = [
    (os.path.join("Accounting", ""), "xero_accounting.yaml"),
    (os.path.join("Payroll", "AU", ""), "xero-payroll-au.yaml"),
    (os.path.join("Payroll", "NZ", ""), "xero-payroll-nz.yaml"),
    (os.path.join("Payroll", "UK", ""), "xero-payroll-uk.yaml"),
    (os.path.join("Files", ""), "xero_files.yaml"),
    (os.path.join("Assets", ""), "xero_assets.yaml"),
    (os.path.join("Projects", ""), "xero-projects.yaml"),
    (os.path.join("Finance", ""), "xero-finance.yaml"),
    (os.path.join("AppStore", ""), "xero-app-store.yaml"),
    (os.path.join("Identity", ""), "xero-identity.yaml"),
]

PHP_GROUP = {
    "string": "string",
    "number": "number",
    "boolean": "boolean",
    "array": "container",
    "object": "container",
    "many": "container",
}

SCHEMA_OVERRIDE = {
    os.path.join("Accounting", "ManualJournal", "JournalLine.php"): "ManualJournalLine",
}

SPEC_GROUP = {
    "string": "string",
    "number": "number",
    "integer": "number",
    "boolean": "boolean",
    "array": "container",
    "object": "container",
}


def _ref_name(value):
    m = re.search(r"#/components/schemas/(\w+)", value)
    return m.group(1) if m else None


def parse_schemas(filename):
    """Return {SchemaName: {propName: spec_group}} for one spec file."""
    raw_props = {}
    schema_type = {}
    in_components = False
    section = None
    cur_schema = None
    in_props = False
    cur_prop = None

    with open(os.path.join(SPECS_DIR, filename), encoding="utf-8") as fh:
        for raw in fh:
            line = raw.rstrip("\n")
            if not line.strip() or line.lstrip().startswith("#"):
                continue
            indent = len(line) - len(line.lstrip())
            key = line.strip()

            if indent == 0:
                in_components = key.startswith("components:")
                section = cur_schema = cur_prop = None
                in_props = False
                continue
            if not in_components:
                continue
            if indent == 2:
                section = key.rstrip(":")
                cur_schema = cur_prop = None
                in_props = False
                continue
            if section != "schemas":
                continue
            if indent == 4 and key.endswith(":"):
                cur_schema = key[:-1].strip("'\"")
                raw_props.setdefault(cur_schema, {})
                in_props = False
                cur_prop = None
                continue
            if cur_schema is None:
                continue
            if indent == 6:
                in_props = key.startswith("properties:")
                m = re.match(r"type:\s*(\w+)", key)
                if m:
                    schema_type[cur_schema] = m.group(1)
                cur_prop = None
                continue
            if indent == 8 and in_props and key.endswith(":"):
                cur_prop = key[:-1].strip("'\"")
                raw_props[cur_schema][cur_prop] = None
                continue
            if indent == 10 and cur_prop is not None:
                m = re.match(r"type:\s*(\w+)", key)
                if m:
                    # Only set type if no $ref has been seen for this property —
                    # $ref is more specific and wins when both appear (e.g. Xero
                    # Projects Task.rate has $ref: Amount then type: number).
                    if raw_props[cur_schema][cur_prop] is None:
                        raw_props[cur_schema][cur_prop] = ("type", SPEC_GROUP.get(m.group(1), "container"))
                elif key.startswith("$ref:"):
                    # $ref always wins; overwrite any previously-seen bare type.
                    raw_props[cur_schema][cur_prop] = ("ref", _ref_name(key))

    def resolve(entry):
        if entry is None:
            return "container"
        kind, val = entry
        if kind == "type":
            return val
        target_type = schema_type.get(val)
        return SPEC_GROUP.get(target_type, "container")

    return {s: {p: resolve(e) for p, e in props.items()} for s, props in raw_props.items()}


def parse_model(path):
    """Return (class_name, {wireName: php_group}, emit_keys) or (None, None, None)."""
    with open(path, encoding="utf-8") as fh:
        code = fh.read()
    if "getDefinitions" not in code:
        return None, None, None
    cm = re.search(r"\bclass\s+(\w+)", code)
    if not cm:
        return None, None, None
    fields = {}
    for wire, ftype in re.findall(r"'([^']+)'\s*=>\s*Field::(\w+)\s*\(", code):
        if ftype in PHP_GROUP:
            fields[wire] = PHP_GROUP[ftype]
    if not fields:
        return None, None, None
    emit = set()
    tm = re.search(r"function toRequest\(\).*?(?=\n    public function |\n}\s*$)", code, re.S)
    if tm:
        for k in re.findall(r"'([A-Za-z0-9_]+)'\s*=>", tm.group(0)):
            emit.add(k)
    return cm.group(1), fields, emit


def spec_for(path):
    rel = os.path.relpath(path, SRC_DIR)
    for frag, spec in PATH_TO_SPEC:
        if rel.startswith(frag):
            return spec
    return None


def best_schema(cls, model_fields, schemas):
    if cls in schemas:
        return cls, True
    want = {f.lower() for f in model_fields}
    best, best_score = None, 0
    for name, props in schemas.items():
        score = len(want & {p.lower() for p in props})
        if score > best_score:
            best, best_score = name, score
    return best, False


def main():
    spec_cache = {}
    findings = []
    models_checked = 0
    models_clean = 0

    for root, _dirs, files in os.walk(SRC_DIR):
        for name in sorted(files):
            if not name.endswith(".php"):
                continue
            path = os.path.join(root, name)
            cls, fields, emit = parse_model(path)
            if not fields:
                continue
            spec = spec_for(path)
            if spec is None:
                continue
            if spec not in spec_cache:
                spec_cache[spec] = parse_schemas(spec)
            schemas = spec_cache[spec]

            all_props = {}
            for props in schemas.values():
                for p, g in props.items():
                    all_props.setdefault(p.lower(), p)

            rel = os.path.relpath(path, SRC_DIR)
            if rel in SCHEMA_OVERRIDE:
                sch, exact = SCHEMA_OVERRIDE[rel], True
            else:
                sch, exact = best_schema(cls, fields, schemas)
            sch_props = schemas.get(sch, {})
            sch_lower = {p.lower(): (p, g) for p, g in sch_props.items()}

            models_checked += 1
            model_findings = []

            checked = {w: g for w, g in fields.items()}
            for w in emit:
                checked.setdefault(w, None)

            for wire, pg in sorted(checked.items()):
                low = wire.lower()
                if low not in all_props:
                    model_findings.append((rel, cls, "GUESSED", f"{wire} (no such property in {spec})"))
                    continue
                if low in sch_lower:
                    real, sg = sch_lower[low]
                    if real != wire:
                        model_findings.append((rel, cls, "CASE", f"{wire} should be {real} (schema {sch})"))
                    elif pg is not None and sg != pg:
                        model_findings.append((rel, cls, "TYPE", f"{wire}: model {pg} vs spec {sg} (schema {sch})"))

            if exact:
                model_low = {f.lower() for f in fields} | {e.lower() for e in emit}
                for prop in sorted(sch_props):
                    if prop.lower() not in model_low:
                        model_findings.append((rel, cls, "MISSING", f"{prop} (in schema {sch}, not in model)"))

            if model_findings:
                findings.extend(model_findings)
            else:
                models_clean += 1

    by_kind = {"GUESSED": [], "CASE": [], "TYPE": [], "MISSING": []}
    for f in findings:
        by_kind[f[2]].append(f)

    print(f"Models checked: {models_checked}  clean: {models_clean}  with findings: {models_checked - models_clean}")
    print(
        f"GUESSED: {len(by_kind['GUESSED'])}  CASE: {len(by_kind['CASE'])}  "
        f"TYPE: {len(by_kind['TYPE'])}  MISSING: {len(by_kind['MISSING'])}\n"
    )
    for kind in ("GUESSED", "CASE", "TYPE", "MISSING"):
        if not by_kind[kind]:
            continue
        print(f"== {kind} ==")
        for rel, cls, _k, detail in by_kind[kind]:
            print(f"  {rel}  [{cls}]  {detail}")
        print()

    if findings:
        print("FAIL: schema drift detected. All findings must be fixed.")
        sys.exit(1)


if __name__ == "__main__":
    main()
