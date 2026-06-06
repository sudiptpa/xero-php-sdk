# PROGRESS — xero-php-sdk

> **Resume guide:** Read this file at the start of every new session. It tells you exactly where things stand, what was done, and what is left. Do not push to remote until the owner reviews locally.

---

## Last Updated

2026-06-06 — Session 3 (coverage grind — Webhooks namespace to 100%) — IN PROGRESS

## Repo State

- **Branch:** `chore/dev-quality-parity`
- **Base:** `main` (dcb3693 — Docs: Updated Projects Notes)
- **Commits on branch:** 2 (`9b1b1fd` quality parity, `4feb8e8` code-review bug fixes) + Session 3 coverage WIP
- **Tests:** 80 test files, 230 tests, 1187 assertions, all passing
- **Coverage:** **79.53% lines** (6185/7777) / 74.15% methods / 27.47% classes (75/273). 100% gate NOT yet passing; ~198 classes with gaps
- **PHPStan:** level `max` — 0 errors
- **Pint:** clean (`php` preset + `declare_strict_types`)
- **CI:** pcov on PHP 8.3, formatter gate (`lint:check`), syntax lint (`lint`)

### Local coverage command

```bash
/opt/homebrew/bin/php vendor/bin/phpunit --configuration phpunit.xml.dist --do-not-cache-result --coverage-text --coverage-clover build/logs/clover.xml
```

Do NOT add as a composer script — local-only, absolute path (Homebrew PHP has pcov; Herd PHP does not).

---

## Resume (next session)

**Start here:** Branch `chore/dev-quality-parity`, 2 commits ahead of `main`, not yet pushed (owner reviews locally first).

**Immediate next task: get coverage to 100%.**

Approach (proven in Session 3 — grind one namespace to 100%, commit, repeat):
1. Run coverage baseline: `/opt/homebrew/bin/php vendor/bin/phpunit --configuration phpunit.xml.dist --do-not-cache-result --coverage-text --coverage-clover build/logs/clover.xml`
2. Parse `build/logs/clover.xml` for exact uncovered methods/lines per file (see one-liner below)
3. Write/extend the mirror test, hydrating models via `fill()` and asserting every getter + helper branch
4. **Watch PHPStan:** `assertInstanceOf(X, $y)` where `$y`'s declared return type is already `X` triggers `staticMethod.alreadyNarrowedType`. Assert behaviour instead, or `assertSame(X::class, $y::class)` for fallback-type checks.

**Done in Session 3:** Webhooks namespace fully covered (`Webhooks`, `WebhookVerifier`, `WebhookEvent`, `WebhookPayload` all 100%), plus `ScopeRequirements` + `ResponseErrorMapper` to 100%.

**Next targets (still 0% or low):** `Payment/InvoiceReference`, `Support/Model` helper branches, `Support/Json` (`extractObject`/`decode`/`ensureAvailable`), then the big Accounting model-getter batch. `Xero.php` (50%), Http layer (`NativeTransport`, `PendingRequest`, `Request`), Auth internals.

Clover uncovered-method/line one-liner:
```bash
/opt/homebrew/bin/php -r '$x=new SimpleXMLElement(file_get_contents("build/logs/clover.xml"));foreach($x->xpath("//file") as $f){if(strpos((string)$f["name"],"YOURCLASS.php")===false)continue;foreach($f->line as $l){if((int)$l["count"]===0)echo $l["num"]." ".$l["name"]."\n";}}'
```

5. Once 100% passes: push branch, open PR, squash-merge.

**After coverage:** tackle Xero API feature gaps (Budgets resource, Invoice Email, Allocations).

---

## Session 3 — 2026-06-06

### Done this session

- [x] Re-ran coverage baseline (77.70% lines at start)
- [x] `ScopeRequirements` → 100% (new `tests/Support/ScopeRequirementsTest`)
- [x] `Webhooks` router → 100% (new `tests/Webhooks/WebhooksTest`)
- [x] `ResponseErrorMapper` → 100% (extended test: misspelled scope, plain 401, 422, 500 fallback)
- [x] `WebhookVerifier` → 100% (extended test: null/empty sig, assertValid pass, header-array, blank/missing/array headers, assertValidHeaders)
- [x] `WebhookEvent` + `WebhookPayload` → 100% (new `tests/Webhooks/WebhookPayloadTest`: getters, aggregators, filters, edge paths for occurredAt/path/resourceName)
- [x] **Whole Webhooks namespace now 100%**
- [x] Http core: `Request`, `Response`, `PendingRequest` → 100% (new RequestTest, ResponseTest, PendingRequestTest)
- [x] `Support/Json` → 100% (new JsonTest; unreachable json-ext guard wrapped in `@codeCoverageIgnore`)
- [x] `Payment/InvoiceReference` → 100% (added to PaymentsTest)
- [x] **Source fix:** `PendingRequest::modifiedSince()` used `DateTimeInterface::RFC7231`, deprecated in PHP 8.5 (in CI matrix). Switched to `gmdate('D, d M Y H:i:s \G\M\T', ...)` — same RFC 7231 HTTP-date, no deprecation, timezone-safe.
- [x] Full suite green (201 tests, 1121 assertions), PHPStan max clean, Pint clean

**Coverage-ignore decision (owner: confirm):** truly-unreachable defensive guards (json extension missing in `Json::ensureAvailable`; will also hit `Model` "Missing method" `LogicException` throws and all of `NativeTransport`'s real-cURL body) cannot be exercised in tests. Used `@codeCoverageIgnoreStart/End` for the json guard. **NB:** the annotation token must be alone on its `//` line — trailing text (e.g. `// @codeCoverageIgnoreStart — note`) silently breaks parsing.

**Still uncoverable without a strategy:** `NativeTransport` (entire class — real cURL, no network in tests; needs either a thin seam to inject a cURL-ish handle, or a blanket `@codeCoverageIgnore` on the class — owner call), `Model` defensive `LogicException` throws (need malformed-fixture models, or ignore).

- [x] **Whole Auth namespace now 100%** — `Token`, `ConnectedAccount`, `ConnectionManager`, `OAuth2`, `OAuth2Client` (Pkce, InMemoryTokenRepository already 100%). New `TokenTest`; extended `ConnectionManagerTest` (authorizationUrl, connections, disconnectConnection, ConnectedAccount getters, + the 3 RuntimeException error paths) and `OAuth2ClientTest` (`manager()`).
- Net so far: 161→213 tests; lines 77.70%→78.82%; classes 56→73 of 273

### Fully-covered namespaces (100%)

- **Webhooks** (all 4 classes)
- **Auth** (all classes)
- **Http** (entire namespace): `Request`, `Response`, `PendingRequest`, `ResponseErrorMapper`, **`NativeTransport`**, FakeTransport
- **Support** (entire namespace): `Model`, `Json`, `Field`, `ScopeRequirements`, `PaginatedCollection`, `ResourceCollection`, `Concerns/*`

`Model` (the core hydrator) was covered with `tests/Support/ModelTest.php`, which defines small fixture models: one valid `GoodModel` exercising every field type plus the `singular()` pluralisation branches (ies/xes/s/none), and a set of deliberately-broken fixtures (missing setter, missing add method, target class without `fill()`) that trigger each `LogicException` guard.

### NativeTransport — SOLVED (loopback integration test)

Resolved with `tests/Http/NativeTransportTest.php`. Rather than mock cURL globals (brittle) or refactor the `final` adapter, the test stands up a real throwaway loopback HTTP server (`php -S` in a `proc_open` child on an OS-assigned free port) and points the real `NativeTransport` at it. The code under test runs in the test process (so pcov instruments it normally); only the peer is external. Covers GET/POST-json/PUT-body, response-header parsing, 4xx→`ResponseErrorMapper`, and the connection-failure→`TransportException` branch (curl to a dead port). The 3 unreachable defensive guards (curl ext missing, `curl_init()===false`, non-string `RETURNTRANSFER` body) are `@codeCoverageIgnore`d. **NativeTransport now 100%.** This is the documented, deliberate exception to the "always FakeTransport" rule — you cannot cover the real adapter by substituting a fake for it.

**Two real PHP 8.5 source fixes surfaced by these tests** (both were latent — only the new tests exercised the lines on 8.5, which is in the CI matrix):
- `PendingRequest::modifiedSince()` — `DateTimeInterface::RFC7231` deprecated → `gmdate(...)`.
- `NativeTransport` — `curl_close()` deprecated (and a no-op since PHP 8.0, so dead code on a `^8.2` package) → removed all three calls; the `CurlHandle` is freed by GC.

---

## Session 2 — 2026-06-02

### Done this session

- [x] Verified quality gates (161 tests pass, PHPStan max clean, Pint clean)
- [x] Committed all working-tree changes as `9b1b1fd` (quality parity)
- [x] Ran `/code-review` — 3 confirmed bugs found and fixed in `4feb8e8`:
  - `ContactGroups::find()` — `?: null` coerced empty `{}` to null instead of blank model
  - `InvoiceReminders::settings()` — `?: $payload` fallback polluted model with raw error envelope
  - `PayItems::get()` — `[$payload]` fallback manufactured a PayItem from the error body
- [x] Ran `/security-review` — clean (4 candidates, all false positives)
- [x] Audited Xero API feature coverage — gap list recorded above
- [x] Established local coverage command (Homebrew PHP has pcov, Herd PHP does not)
- [x] Measured coverage baseline: **76.29%** (7876/10324 elements), 217 classes with gaps

---

## Session 1 — 2026-06-02

### Done this session

- [x] Created branch `chore/dev-quality-parity`
- [x] Added `.claude/settings.json` — no-push convention, allowed commands deny-list for `git push`
- [x] Added `CLAUDE.md` — architecture rules, non-negotiables, testing conventions, security rules
- [x] Added `PROGRESS.md` (this file)
- [x] Added Pint (`php` preset + `declare_strict_types: true`)
- [x] Updated `composer.json` — added `format`, `lint:fix`, `lint:check` scripts, bumped phpstan to `^2.2`, added `phpstan/phpstan-phpunit`
- [x] Bumped PHPStan to level `max`, fixed all 795 errors (0 remaining)
- [x] Added 100% coverage enforcement via Clover XML parse in `bin/coverage`
- [x] Switched CI to `pcov` for coverage
- [x] Added formatter check step (`composer lint:check`) to CI
- [x] Added `composer lint` step to CI (php -l syntax check on src + tests)
- [x] Copied caveman skills from sent-dm (caveman, caveman-commit, caveman-compress, caveman-help, caveman-review, caveman-stats, cavecrew)
- [x] Bumped `phpstan/phpstan` to `^2.2` (latest)
- [x] Fixed `InvoiceReminderSettings` hydration bug (extractFirst vs extractObject)
- [x] Added `Json::extractList`, `Json::extractFirst`, `Json::extractObject` helpers to Support/Json.php
- [x] Run `/code-review` — 3 confirmed bugs fixed in `4feb8e8`
- [x] Run `/security-review` — clean (0 findings above threshold)
- [x] Xero API coverage audit — gap analysis produced (see below)
- [ ] 100% code coverage — currently **76.29%**, 217 classes with gaps (see below)

---

## What Is Done (fully implemented)

### Source (285 files, 15 namespaces)

- **Accounting** — full Xero Accounting API (Contacts, Invoices, Payments, BankTransactions, CreditNotes, PurchaseOrders, Quotes, Receipts, ManualJournals, etc.)
- **Payroll AU** — Employees, LeaveApplications, PayItems, PayRuns, PayrollCalendars, SuperFunds, Timesheets, Settings
- **Payroll NZ** — Employees, LeaveTypes, PayRuns, PayRunCalendars, Timesheets, Settings
- **Payroll UK** — Employees, PayRuns, PayRunCalendars, Timesheets, Settings
- **Files** — Files, Folders with upload and association
- **Assets** — Assets, Type, Settings
- **Projects** — Projects, ProjectUsers, Tasks, TimeEntries
- **Finance** — FinancialStatements, AccountingActivities, CashValidation, BankStatementAccounting
- **AppStore** — Subscriptions, UsageRecords
- **Identity** — Connections, Connection management
- **Auth** — OAuth2, OAuth2Client, PKCE, Token, TokenRepository, InMemoryTokenRepository, ConnectionManager, ConnectedAccount
- **Http** — Request, Response, NativeTransport, FakeTransport, PendingRequest, ResponseErrorMapper
- **Exceptions** — XeroException, AuthenticationException, RateLimitException, ValidationException, TransportException, RequestException, InsufficientScopeException, InvalidWebhookSignatureException
- **Support** — Model (hydration), Field, Json, PaginatedCollection, ResourceCollection, ScopeRequirements, BuildsQueries, HasPagination, InteractsWithBindings, DefinesScopes, PaginatesResults, SerializesRequest
- **Webhooks** — WebhookVerifier (HMAC-SHA256), WebhookPayload, WebhookEvent

### Tests (71 files)

- Accounting (35 test files)
- Payroll AU/NZ/UK (15 test files)
- Auth (3 test files)
- Files, Assets, Finance, Identity, Projects, AppStore, Http, Webhooks, Client

---

## Dependency Status

| Package | Installed | Latest | Action |
|---|---|---|---|
| `phpstan/phpstan` | 2.1.43 | 2.2.1 | Update to `^2.2` this session |
| `phpunit/phpunit` | 11.5.55 | 13.1.13 | **Blocked** — PHPUnit 12+ requires PHP ≥8.3; package supports 8.2. Stay on `^11.5` until PHP 8.2 EOL. |

---

## Pre-Release Checklist

- [x] PHPStan max — clean (0 errors)
- [x] Pint — clean (no formatting issues)
- [ ] **100% test coverage** — currently 76.29%, major test-writing work needed
- [ ] PHPDoc coverage — all public methods documented
- [x] `/code-review` — 3 bugs fixed (ContactGroups, InvoiceReminders, PayItems)
- [x] `/security-review` — clean
- [ ] Xero API feature gaps addressed (Budgets, Invoice Email, Allocations — see below)
- [ ] `CHANGELOG.md` — updated for next release
- [ ] CI green on all PHP versions (8.2, 8.3, 8.4, 8.5)
- [ ] Local review by owner before push

---

## Architecture Decisions

| Decision | Why |
|---|---|
| PHPUnit over Pest | Framework-agnostic library — PHPUnit is the standard, no Laravel bootstrap needed |
| No runtime dependencies | Runs anywhere PHP runs — no Guzzle, no Laravel, no Symfony |
| `NativeTransport` as default | cURL is available everywhere; optional Guzzle via custom Transport |
| `Context` is readonly | Immutable value object — tenant/token changes produce new instances |
| `Model::fill()` for hydration | Single hydration path, type-safe via `Field` definitions, no magic |
| `FakeTransport` not mocks | Tests the full request path including headers and URL construction |
| `final` on Client, Context, Xero | Not extension points — use `Transport` contract for customisation |
| PHP `^8.2 <8.6` | Covers current active + security maintenance PHP versions |

---

## Known Gotchas

| Area | Gotcha |
|---|---|
| Payroll regions | `$client->payroll()` returns a `Payroll` router — then call `->au()`, `->nz()`, or `->uk()` |
| Tenant header | Most endpoints require `Xero-Tenant-Id` — set via `$client->tenant($tenantId)` |
| PDF responses | Some accounting endpoints return PDF — use `->withHeaders(['Accept' => 'application/pdf'])` |
| Webhook signature | Must verify every payload — `WebhookVerifier::verify()` throws `InvalidWebhookSignatureException` |
| OAuth2 state | Must be validated server-side — the SDK provides `Xero::authorizationUrl()` but state validation is the consumer's responsibility |
| PKCE flow | Code verifier must be stored between auth request and token exchange |
| FakeTransport order | Responses dequeue FIFO — push them in the order they will be consumed |
| Identity connections | Calls `/connections` without tenant header — use `->withoutTenant()` |

---

## CI Matrix

| PHP | Coverage |
|---|---|
| 8.2 | no |
| 8.3 | pcov (100% gate) |
| 8.4 | no |
| 8.5 | no |

---

## Xero API Feature Coverage Gaps (Session 2 audit)

### Accounting — confirmed missing

| Endpoint | Priority |
|---|---|
| `GET/POST/PUT /Budgets` — entire resource missing | **High** |
| `POST /Invoices/{id}/Email` — send invoice email | **High** |
| `PUT /Overpayments/{id}/Allocations` + History | **High** |
| `PUT /Prepayments/{id}/Allocations` + History | **High** |
| `GET/PUT /Contacts/{id}/History` | Medium |
| `GET /Contacts/{id}/Attachments` | Medium |
| `DELETE /BatchPayments` | Medium |
| `GET /Invoices/{id}/OnlineInvoice` | Medium |
| `GET /Quotes/{id}/Attachments` + History | Low |
| `GET /BrandingThemes/{id}/PaymentServices` | Low |

All other API groups (Payroll AU/NZ/UK, Finance, Files, Assets, Projects, AppStore, Identity, Webhooks) — **no significant gaps**.

---

## Coverage Gaps (Session 2 — 76.29% baseline)

- **149 classes** missing 1–3 methods (closable in bulk with model getter tests)
- **68 classes** missing 4+ methods (deeper test work needed)
- Biggest categories: model `get*()` methods never called in tests, some Payload create/update paths, Http/Auth internals, Json helper methods

Next session priority order:
1. 0%-coverage classes: `ScopeRequirements`, `ResponseErrorMapper`, `Webhooks`, `Payment/InvoiceReference`
2. Model getter coverage (add property assertions to existing response tests)
3. Json helper methods (`extractObject`, `decode`, `ensureAvailable`)
4. Http layer (`NativeTransport`, `PendingRequest`, `Request`)
5. Webhook methods (`WebhookVerifier`, `WebhookEvent`, `WebhookPayload`)

---

## Code Review Findings (Session 2 — fixed in `4feb8e8`)

| # | File | Issue | Status |
|---|---|---|---|
| 1 | `ContactGroups::find()` | `extractObject() ?: null` coerces empty `{}` response to null instead of blank model | **Fixed** |
| 2 | `InvoiceReminders::settings()` | `?: $payload` third fallback passed raw envelope to mapper | **Fixed** |
| 3 | `PayItems::get()` | `[$payload]` fallback manufactured a PayItem from error envelope | **Fixed** |
| 4 | `Json::extractList` | Silently discards non-array list items (plausible signal regression) | Open — low priority |
| 5 | `NZ/UK PayRunCalendars::find()` | Four-block cascade with `!== []` exists because `extractObject` returns `[]` not `null` | Open — cleanup |

---

## Workflow Notes

- All work is squash-merged on GitHub
- Do not push until owner reviews locally (enforced via `.claude/settings.json` deny list)
- Each session should end with updated `PROGRESS.md` status and a clean `composer test && composer stan` run

### Commit message rules (owner preference)

- Keep messages simple and clear. Short subject, plain body only when the "why" needs it.
- No em-dashes or other "AI-tell" punctuation/keywords. Use plain ASCII: commas, parentheses, colons.
- Never add `Co-Authored-By` AI lines or any note that a commit was made by an AI.
- Conventional Commits prefix (`test:`, `fix:`, `chore:`) is fine.
