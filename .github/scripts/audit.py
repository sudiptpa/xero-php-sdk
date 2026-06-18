#!/usr/bin/env python3
"""Endpoint audit: Xero OpenAPI specs vs implemented SDK routes.

Parses OpenAPI YAML specs and diffs every documented method+path against
request paths the SDK can build in src/. Exits 1 if any spec endpoint is
not implemented.

Specs are read from the directory in the XERO_SPECS_DIR environment variable,
defaulting to ../../openapi relative to this script (the local working copy).

Two matching tiers:
  exact - the path appears in a direct ->get/post/put/delete('...') call
  path  - the path is buildable somewhere in src; verb not statically verified
"""
import os
import re
import sys

HERE = os.path.dirname(os.path.abspath(__file__))
SRC_DIR = os.path.join(HERE, "..", "..", "src")
SPECS_DIR = os.environ.get("XERO_SPECS_DIR", os.path.join(HERE, "..", "..", "openapi"))

SPECS = {
    "xero_accounting.yaml": ("Accounting", "/api.xro/2.0"),
    "xero-payroll-au.yaml": ("Payroll AU", "/payroll.xro/1.0"),
    "xero-payroll-nz.yaml": ("Payroll NZ", "/payroll.xro/2.0"),
    "xero-payroll-uk.yaml": ("Payroll UK", "/payroll.xro/2.0"),
    "xero_files.yaml": ("Files", "/files.xro/1.0"),
    "xero_assets.yaml": ("Assets", "/assets.xro/1.0"),
    "xero-projects.yaml": ("Projects", "/projects.xro/2.0"),
    "xero-finance.yaml": ("Finance", "/finance.xro/1.0"),
    "xero-app-store.yaml": ("AppStore", "/appstore/2.0"),
    "xero-identity.yaml": ("Identity", ""),
}

HTTP_METHODS = {"get", "put", "post", "delete", "patch", "head", "options"}

# Shared path-based sub-resource classes receive a full base path in their
# constructor and build these verb+suffix routes from it.
SHARED_SUBRESOURCES = {
    "Allocations": [("PUT", ""), ("DELETE", "/{id}")],
    "Attachments": [("GET", ""), ("GET", "/{id}"), ("PUT", "/{id}"), ("POST", "/{id}")],
    "History": [("GET", ""), ("PUT", "")],
}

CONCAT_PART = r"'(?:[^'\\]|\\.)*'|[^'.,)(]+(?:\([^)]*\))?"
CONCAT_EXPR = rf"(?:{CONCAT_PART})(?:\s*\.\s*(?:{CONCAT_PART}))*"


def norm(path: str) -> str:
    path = re.sub(r"\{[^}]+\}", "{id}", path)
    path = re.sub(r"(\{id\})+", "{id}", path)
    return path.rstrip("/").lower()


def parse_spec(filename: str):
    endpoints = []
    in_paths = False
    current_path = None
    with open(os.path.join(SPECS_DIR, filename), encoding="utf-8") as fh:
        for raw in fh:
            line = raw.rstrip("\n")
            if not line.strip() or line.lstrip().startswith("#"):
                continue
            indent = len(line) - len(line.lstrip())
            if indent == 0:
                in_paths = line.startswith("paths:")
                current_path = None
                continue
            if not in_paths:
                continue
            key = line.strip()
            if indent == 2 and key.startswith("/") and key.endswith(":"):
                current_path = key[:-1].strip("'\"")
            elif indent == 4 and current_path:
                m = re.match(r"^([a-z]+):", key)
                if m and m.group(1) in HTTP_METHODS:
                    endpoints.append((m.group(1).upper(), current_path))
    return endpoints


def concat_to_path(expr: str) -> str:
    built = ""
    for part in re.split(r"\s*\.\s*(?=(?:[^']*'[^']*')*[^']*$)", expr):
        part = part.strip()
        if not part:
            continue
        if part.startswith("'") and part.endswith("'"):
            built += part[1:-1]
        else:
            built += "{id}"
    return built


def implemented_routes():
    exact = set()
    loose = set()
    call_re = re.compile(rf"->(get|post|put|patch|delete)\(\s*({CONCAT_EXPR})", re.S)
    anylit_re = re.compile(rf"('/(?:[^'\\]|\\.)*'(?:\s*\.\s*(?:{CONCAT_PART}))*)", re.S)
    assign_re = re.compile(r"\$(\w+)\s*=\s*('/(?:[^'\\]|\\.)*')\s*;")
    append_re = re.compile(rf"\$(\w+)\s*\.=\s*({CONCAT_EXPR})\s*;")
    shared_names = "|".join(SHARED_SUBRESOURCES)
    shared_re = re.compile(
        rf"new\s+({shared_names})\(\s*\$this->client\s*,\s*({CONCAT_EXPR})\)", re.S
    )
    const_re = re.compile(r"const\s+(\w+)\s*=\s*'((?:[^'\\]|\\.)*)'\s*;")

    for root, _dirs, files in os.walk(SRC_DIR):
        for name in files:
            if not name.endswith(".php"):
                continue
            with open(os.path.join(root, name), encoding="utf-8") as fh:
                code = fh.read()

            for cname, cval in const_re.findall(code):
                code = code.replace(f"self::{cname}", f"'{cval}'")

            for m in call_re.finditer(code):
                built = concat_to_path(m.group(2))
                if built.startswith("/"):
                    exact.add((m.group(1).upper(), norm(built)))
                    loose.add(norm(built))

            for m in anylit_re.finditer(code):
                built = concat_to_path(m.group(1))
                if built.startswith("/"):
                    loose.add(norm(built))

            bases = {v: lit[1:-1] for v, lit in assign_re.findall(code)}
            for var, expr in append_re.findall(code):
                if var in bases:
                    combined = bases[var] + concat_to_path(expr)
                    loose.add(norm(combined))

            for m in shared_re.finditer(code):
                base = concat_to_path(m.group(2))
                if not base.startswith("/"):
                    continue
                for verb, suffix in SHARED_SUBRESOURCES[m.group(1)]:
                    exact.add((verb, norm(base + suffix)))
                    loose.add(norm(base + suffix))

    return exact, loose


def main():
    exact, loose = implemented_routes()
    grand_total = grand_exact = grand_path = 0
    report = []
    has_missing = False

    for spec, (label, prefix) in SPECS.items():
        eps = sorted(set(parse_spec(spec)))
        missing = []
        n_exact = n_path = 0
        for method, path in eps:
            full = norm(prefix + path)
            if (method, full) in exact:
                n_exact += 1
            elif full in loose:
                n_path += 1
            else:
                missing.append(f"  MISSING {method:6} {path}")
                has_missing = True
        grand_total += len(eps)
        grand_exact += n_exact
        grand_path += n_path
        report.append(
            f"\n== {label} ({spec}): {n_exact + n_path}/{len(eps)} implemented"
            f" ({n_exact} exact, {n_path} path-only) =="
        )
        report.extend(missing)

    print(
        f"TOTAL: {grand_exact + grand_path}/{grand_total} spec endpoints implemented"
        f" ({grand_exact} verb-verified, {grand_path} path-matched)"
    )
    print("\n".join(report))

    if has_missing:
        print("\nFAIL: missing endpoints detected.")
        sys.exit(1)


if __name__ == "__main__":
    main()
