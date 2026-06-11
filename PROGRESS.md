# PROGRESS — xero-php-sdk

> **Resume guide:** Read this file at the start of every new session. It tells you exactly where things stand, what was done, and what is left. Do not push to remote until the owner reviews locally.

---

## Last Updated

2026-06-11 — Session 7 (**100% coverage gate DONE**: Payroll AU finished, Payroll NZ + UK done to 100%, then Client/Context/Xero entry-point leftovers; gate parse confirms 10311/10311 elements)

## Repo State

- **Branch:** `chore/dev-quality-parity`
- **Base:** `main` (dcb3693 — Docs: Updated Projects Notes)
- **Tests:** 487 tests, 2028 assertions, all passing
- **Coverage:** **100.00% lines (7777/7777), 100% elements (10311/10311)** — the `bin/coverage --min=100` clover parse passes. Verified per-line with the pcov dump (zero uncovered lines anywhere in `src/`).
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

**Start here:** Branch `chore/dev-quality-parity`. Not yet pushed (owner reviews locally first). **The 100% coverage gate is DONE — nothing left to cover.**

**Next tasks, in order:**
1. Owner reviews the branch locally, then push + PR + squash-merge (the no-push rule still applies until then).
2. Xero API feature gaps: run the Phase 1 OpenAPI endpoint-coverage matrix (see "Feature Coverage Audit Plan" below), then implement the confirmed Accounting gaps (Budgets resource, Invoice Email, Overpayment/Prepayment Allocations, Contact History/Attachments, DELETE BatchPayments, OnlineInvoice).
3. Remaining pre-release checklist items: PHPDoc coverage pass, CHANGELOG update, CI green on 8.2/8.3/8.4/8.5.

The per-line uncovered dump below stays useful for keeping the gate green when adding those new endpoints.

### Preferred per-line uncovered dump (precise, used all of Session 6)

```bash
# 1. produce the coverage object once
/opt/homebrew/bin/php vendor/bin/phpunit --configuration phpunit.xml.dist --do-not-cache-result --coverage-php /tmp/xero.cov
# 2. dump uncovered lines for a path substring (edit the strpos arg)
/opt/homebrew/bin/php -r '
require "vendor/autoload.php";
$cov = require "/tmp/xero.cov";
foreach ($cov->getData()->lineCoverage() as $file => $lines) {
  if (strpos($file, "/Payroll/AU/PayRun/") === false) continue;   // <-- edit this
  $un = [];
  foreach ($lines as $ln => $t) { if (is_array($t) && count($t) === 0) $un[] = $ln; }
  if ($un) echo basename($file).": ".implode(",", $un)."\n";
}'
```
(Homebrew PHP has pcov; the autoload require is mandatory or the .cov object is incomplete.)

### Reusable patterns confirmed in Sessions 6-7 (apply verbatim when adding new endpoints)

- **Resource `Xxxs.php`:** the two always-uncovered methods are `scopes()` and `paginate()`. Add (a) a `scopes()` test asserting `->broad` / `->granular` exact arrays, and (b) a `paginate(page:, perPage:)` test asserting `query['page']`/`query['pageSize']` and `$page->page`/`$page->perPage`. (AU scope strings differ per resource: employees/leave = `payroll.employees`, payitems/settings = `payroll.settings`, payruns/payslips = `payroll.payruns`.)
- **Model getters not hit by `fill()`:** the response fixtures omit some keys, so their setters/getters never run. Build the model via `(new X())->fill([...all keys...])` and assert each getter. (Number fields keep `int`, e.g. `getTotal()` returns `80` not `80.0`; AU Payment `Amount` is cast to float.)
- **Model `save()`:** existing tests drive the resource `create()/update()` Payload, never the model's own `save()`. Cover it by `find()`-ing a bound model, mutating it, then `->save()` (queue a 2nd response). Each model also has a no-client `save()` throw — one `expectException(RuntimeException)` test on `(new X())->save()`.
- **`Payload` `idempotencyKey()` + empty-response:** chain `->idempotencyKey('k')->save()` against a `'{}'` body; assert `requests()[0]->headers['Idempotency-Key']` and that the returned model is the blank fallback (its id getter is null).
- **Sub-resource accessors** (attachments/history/pdf/payslips/leaveBalances/approve/reject): success path covered by calling on a `find()`-ed bound model; the no-client/no-id throw needs `(new X())->method()` under `expectException`.
- **PHPStan gotchas (still biting):** don't `assertInstanceOf`/`assertNotNull`/`assertSame(X::class,...)` on a value whose declared return type already says so — `staticMethod.alreadyNarrowedType` / `impossibleType`. Assert behaviour instead. Also avoid `?->` after a narrowing assertion on the same var (`nullsafe.neverNull`). Don't offset-access the `mixed` from `toRequest()` — assert via getters.
- **Per-resource commit:** `test: cover Payroll AU <Resource> resource to 100%`. **NB the on-disk dir is `tests/Payroll/AU/` (uppercase) — `git add` with lowercase `Au` silently matches nothing on this case-insensitive FS.**

---

## Session 7 — 2026-06-11

### Done this session — **100% coverage gate achieved**

One resource per commit, each verified with the per-line pcov dump, PHPStan max, and Pint before committing:

- [x] **Payroll AU finished:** PayRun (`189afed`), PayrollCalendar (`76fce57`), Settings (`2d59fa4`), SuperFund (`bcc1ccc`), Timesheet (`456e247`), Employee payload leftovers (`81db241`). **AU = 0 uncovered lines.**
- [x] **Payroll NZ done:** Employee (`d9fee67`, incl. the 9 multi-line unbound-guard throws + LeavePayload `title()`), LeaveType (`970c049`), PayRun (`e9ae720`), PayRunCalendar (`94fa57a`), Settings (`7a999c8`, incl. blank-settings `'{}'` fallback), Timesheet (`98a45f1`, incl. approve/revert/delete throws). **NZ = 0 uncovered lines.**
- [x] **Payroll UK done:** Employee (`d3a3ac0`, incl. LeavePayload + LeaveTypePayload idempotency keys), PayRun (`9919722`, incl. the 11-field model fill), PayRunCalendar (`6e25de5`), Settings (`02e2c88`, Reimbursement/StatutoryLeaveSummary/TrackingCategory), Timesheet (`a0d24b2`). **UK = 0 uncovered lines.**
- [x] **Top-level leftovers** not in the original Payroll-only estimate (`5a96bf1`): `Client::withToken()`/`webhooks()`, `Context::tenantHeaders()` empty branch, `Xero::authorizationUrl()/oauth2()/pkce()`.
- [x] Final state: **487 tests, 2028 assertions, 7777/7777 lines, 10311/10311 clover elements (100%)**, PHPStan max clean, Pint clean.

### Notes for future sessions

- One new PHPStan gotcha: a no-arg accessor called bare for coverage trips `method.resultUnused` — assert behaviour through the returned object instead (done for `Client::webhooks()` via a real HMAC verify round-trip).
- `bin/coverage` hardcodes plain `php` (Herd, no pcov) so it warns "No code coverage driver available" locally; the clover parse stage is what CI enforces. Locally, generate clover with `/opt/homebrew/bin/php vendor/bin/phpunit ... --coverage-clover build/logs/clover.xml` and run the same simplexml parse to confirm the gate.
- Fill-fixture values were taken from the Xero API docs shapes (AU payroll uses `/Date(...)/` MS-JSON dates, NZ/UK payroll v2 use ISO dates; AU scope strings differ per resource: employees/leave = `payroll.employees`, payitems/settings/calendars/superfunds = `payroll.settings`, payruns/payslips = `payroll.payruns`, timesheets = `payroll.timesheets`).

---

## Session 6 — 2026-06-11

### Done this session

- [x] **Committed the Session 5 WIP cleanly.** The 7 finished namespaces (Http remainder, AppStore, Identity, Assets, Finance, Projects, Files) were sitting uncommitted/pre-staged; split them into one commit per namespace (`d3b1b13`..`ef8f36a`).
- [x] **Finished the entire Accounting namespace to 100%** — one resource per commit:
  - Contact, BankTransaction, CreditNote, Invoice, PurchaseOrder, Quote, Payment, ManualJournal, BatchPayment.
  - Each followed the same recipe: resource `scopes()` + `paginate()`, model getters via `fill()`, `Payload` builder chain (contact/lineItem/reference/etc), model `save()` no-client throw, and sub-resource accessors (attachments/history/pdf) success-path + unbound throws.
  - **Accounting is now 0 uncovered lines.**
- [x] **Started Payroll AU:** Employee, LeaveApplication, PayItem to 100% (`fbf402b`, `7326623`, `9f0ad8c`).
- [x] Full suite green throughout (386 tests at pause), PHPStan max clean, Pint clean.

### Net for the session

- Tests 308 -> 386; lines 88.38% -> **95.10%** (7396/7777); classes 187 -> 215 of 273 at 100%.
- **Accounting fully covered. Only Payroll (AU partial, NZ + UK untouched) remains for the 100% gate.**
- **Paused mid Payroll AU at owner's request** (other work to do). Next resource is AU PayRun — see the Resume section for the exact remaining AU/NZ/UK target list and the reusable patterns.

---

## Session 5 — 2026-06-11

### Done this session

Grind continued, one namespace to 100% per step (verified with a per-line pcov dump, not just the summary):

- [x] **Http** remainder → 100%: `FakeTransport` (new `tests/Http/FakeTransportTest` — ordered dequeue, request recording, empty-queue `RuntimeException`); `PendingRequest` `withQuery`/`withJson`/`withBody` (added to `PendingRequestTest`).
- [x] **AppStore** namespace → 100% (new `tests/AppStore/AppStoreTest`): `scopes()` on AppStore + Subscriptions, all remaining Subscription/UsageRecord getters, both unbound-context guards on `Subscription`, and the missing-item-id guard in `UsageRecordPayload::path()`.
- [x] **Identity** namespace → 100% (extended `ConnectionsTest`): remaining `Connection` getters, the unbound-context `disconnect()` guard, and the `findByTenant()` no-match `return null`. (Webhooks was already 100%.)
- [x] **Assets** namespace → 100% (new `tests/Assets/AssetsCoverageTest`): facade `scopes()`/`client()`, Asset getters + nested `AssetType` fill, `scopes()` on Asset/Type resources, Payload `warrantyExpiryDate`/`poolName` + empty-response `save()` + no-idempotency headers, Settings default-account getters + `fetch()` null branch, Type getters/setters.
- [x] **Finance** namespace → 100% (new `tests/Finance/FinanceCoverageTest`): `scopes()` across all 5 endpoints, every model getter (AccountUsage/AccountingActivity/LockHistory/ReportHistory/UserActivity/BankStatementEntry/CashValidationResult/ContactStatement/Statement), and the empty-statement typed fallback in `FinancialStatements::statement()`.
- [x] **Projects** namespace → 100% (new `tests/Projects/ProjectsCoverageTest`, 15 tests): facade delegation, all model getters/setters, nested `Contact`/`Rate` hydration, every `RuntimeException` guard on Project/Task/TimeEntry, resource builders (ids/contact/invoice/dateBeforeUtc/...), pagination, `update()`, the `single()` `many()[0]` fallback, empty-response `save()` branches, no-idempotency headers.
- [x] **Files** namespace → 100% (new `tests/Files/FilesCoverageTest`, 10 tests): facade delegation + resource `client()`, File/Folder/Association/AssociationCount getters, nested `FolderId` hydration, all entity guards, Associations/ObjectAssociations `scopes()` + pagination, File/Folder Payload POST + idempotency + empty-response, no-folder Upload branch.
- [x] Full suite green (308 tests, 1553 assertions), PHPStan max clean, Pint clean.

### Net for the session

- Tests 262 -> 308; lines 83.95% -> 88.38% (6873/7777); classes 126/273 -> 187/280 at 100%.
- **Every namespace except Accounting and Payroll is now fully covered.**

### Patterns reconfirmed / worth remembering

- Local per-line uncovered dump (more precise than `--coverage-text` for targeting): run with `--coverage-php /tmp/x.cov`, then `require` it under the pcov-loaded CLI and walk `getData()->lineCoverage()` for `count === 0` lines. (Herd PHP has no pcov; load it explicitly: `php -d extension=/opt/homebrew/lib/php/pecl/20240924/pcov.so -d pcov.enabled=1 ...`.)
- PHPStan `staticMethod.alreadyNarrowedType` keeps biting: `assertNotNull`/`assertInstanceOf` on a builder whose declared return type is already non-null/concrete. Fix by asserting behaviour instead — e.g. drive the returned `Payload` through `->save()` and assert the request method/path, or assert `->scopes()->broad`, rather than asserting the object exists.
- Empty-response `save()` branches (`extractFirst(...) ?? []` then `=== []` -> blank model) are reachable with a `'{}'` or `'[]'` body.
- `single()`'s `many()[0]` fallback needs a body whose object key is absent but a list key (Items) is present.

### Fully-covered namespaces (100%) — updated

- **Webhooks**, **Auth**, **Http**, **Support** (from Session 3)
- **AppStore**, **Identity**, **Assets**, **Finance**, **Projects**, **Files** (Session 5)
- Remaining with gaps: **Accounting** (large resources) and **Payroll** AU/NZ/UK only.

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

### Accounting (in progress, one resource cluster per commit)

Done to 100%: **BrandingTheme, Currency, InvoiceReminder, Organisation, PaymentService, User, Employee, ExpenseClaim, Journal, Receipt, RepeatingInvoice, Report, Account, Item, TaxRate, TrackingCategory, ContactGroup, Overpayment, Prepayment, BankTransfer, LinkedTransaction** (extended the existing resource tests).

Remaining Accounting resources (the largest, most with attachment/history sub-resources): **Contact, Invoice, CreditNote, BankTransaction, BatchPayment, PurchaseOrder, Quote, ManualJournal, Payment**.

Third cluster (Account, Item, TaxRate, TrackingCategory, ContactGroup) extra notes:
- `paginate($page, $perPage)` returns a `PaginatedCollection` whose items live on `->items` (a `ResourceCollection`); it has no `first()` of its own. Page/perPage are on `->page`/`->perPage`.
- Resource `update($id)` returns a `Payload`; the model `save()` PUTs to `/Resource/{id}` when the id is set, otherwise POSTs to `/Resource`. Builder-style `Payload` methods (code/name/type/description/status/contact/component) are separate from the model fluent methods and need their own coverage via `create()`/`update()` chains.
- Resource `map*()` helpers (mapComponent, mapOption) and model bulk setters (setTaxComponents, setOptions) are often not exercised by `fill()`; call them directly.
- Shared History class is `Sujip\Xero\Accounting\History`, not per-resource.
- `assertInstanceOf`/`assertSame(X::class, $y::class)` on a `final` class with a declared return type both trip PHPStan (`alreadyNarrowedType`/`impossibleType`); just invoke the method for coverage and let the other assertions carry the test.

Extra patterns learnt in the second cluster:
- `update($id)` returns a `Payload`; cover it plus `Payload::idempotencyKey()` by calling `update(...)->...->idempotencyKey(...)->save()` with an extra queued response.
- Model `save()` without a bound client throws `RuntimeException` (one short test each).
- Resource sub-accessors like `Receipt::attachments()`/`history()` throw without a client/id (one test each, since `expectException` stops at the first throw).
- A model's `newDefinitionInstance()` override that special-cases one class (e.g. `Contact`) has an unreachable parent-fallback when no other class is used in its definitions; cover it with a `ReflectionMethod` call passing a different model class.
- Number fields keep `int` (e.g. `getTotal()` returns `80`, not `80.0`).
- PHPStan's PHPUnit extension narrows a variable to non-null after `assertSame('literal', $x?->method())`, so later `?->` on the same variable trips `nullsafe.neverNull`; use plain `->` after the first narrowing assertion.

Pattern for Accounting resources (the bulk of the remaining gap):
- Unused model getters: assert them on the model returned by the existing `get()`/`find()` test (enrich the response body with the fields if needed).
- Each resource has a `scopes()` method (from `DefinesScopes`) that is never called: add one assertion. Note some resources have empty `granular` by design (e.g. PaymentServices), so assert the actual shape, not just "non-empty".
- Watch for error/fallback branches: model `save()` without a bound client throws; some `settings()`/`find()` readers have a second `?:` extract fallback for an alternate JSON key.
- `ResourceCollection::first()` is non-nullable in these generic contexts, so do not use `?->` on it (PHPStan `nullsafe.neverNull`).

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
- [x] **100% test coverage** — 7777/7777 lines, 10311/10311 elements (Session 7)
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

> NOTE: the table above was eyeballed, not systematic. Replace it with the OpenAPI-diff matrix from the audit plan below.

---

## Feature Coverage Audit Plan (Session 4)

Distinguish two axes:
- **Test coverage** — lines/methods of existing code (the 100% gate we are grinding). Currently ~84%.
- **Feature coverage** — does the SDK implement every Xero endpoint? Separate. Not yet systematically measured.

### Sources of truth

- **Xero-OpenAPI** (https://github.com/XeroAPI/Xero-OpenAPI, MIT) — official machine-readable specs, one YAML per API. This is the basis for the completeness audit. Raw URL pattern: `https://raw.githubusercontent.com/XeroAPI/Xero-OpenAPI/master/<file>`.
  - `xero_accounting.yaml`, `xero-payroll-au.yaml` (+ `-au-v2`), `xero-payroll-uk.yaml`, `xero-payroll-nz.yaml`, `xero_files.yaml`, `xero_assets.yaml`, `xero-projects.yaml`, `xero-finance.yaml`, `xero-app-store.yaml`, `xero-identity.yaml`, `xero_bankfeeds.yaml`, `xero-webhooks.yaml`.
- **xero-mcp-server** (https://github.com/xeroapi/xero-mcp-server) — NOT an endpoint reference. ~50 AI tools, partial surface (common Accounting + some Payroll/Reports), read+write, needs a Custom Connection (client-credentials) or bearer token. Useful only as a dev-time dataset/shape validation aid, not for completeness.

### Plan

**Phase 1 — endpoint completeness (no credentials, scriptable):**
1. Pull each `*.yaml` spec into a gitignored scratch dir.
2. Extract every `path` + HTTP method + response schema name.
3. Diff against implemented routes: grep `->get/post/put/patch/delete('/api.xro/...'` and the Finance/Projects/etc. base URIs across `src/`.
4. Emit a matrix: endpoint -> implemented? -> tested? This replaces the eyeballed gap table above.

**Phase 2 — schema/field validation (spec-driven, no credentials):**
- For each implemented `Model`, diff its `Field` definitions against the OpenAPI component schema's properties. Flags missing fields, wrong types, stale names. This is where latent bugs hide (the test grind already surfaced two PHP 8.5 ones; schema drift is the next likely class).

**Phase 3 — live dataset validation (needs credentials; MCP helps):**
- Use xero-mcp-server against the **Xero Demo Company only** (never a real org; write ops are side-effecting). Fetch live records via MCP tools and diff actual JSON against our hydration.
- For endpoints the MCP server does not cover, fall back to a Demo Company token + saved JSON fixtures.

### Boundaries / decisions

- MCP stays a **dev-time aid**, never a package dependency (respects the zero-runtime-dependency rule).
- MCP needs the owner's Custom Connection credentials / Demo Company token — Claude cannot create these. Phases 1-2 are credential-free and deliver most of the value (real gap list + schema drift); Phase 3 is the polish.
- Do not commit any Xero tokens or client secrets.

### Status

- [ ] Phase 1 — OpenAPI endpoint-coverage matrix (not started)
- [ ] Phase 2 — Model field vs OpenAPI schema diff (not started)
- [ ] Phase 3 — live Demo Company validation via MCP (blocked on owner credentials)

Decision pending: run Phase 1 now, or finish the test-coverage grind (Contact next) first and audit after.

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
