# Security Policy

## Supported versions

Security fixes land on the latest released major version. Please make sure you
are on the most recent release before reporting an issue.

## Reporting a vulnerability

Please do not open a public issue for security problems.

Report privately through GitHub's [security advisory form](https://github.com/sudiptpa/xero-php-sdk/security/advisories/new).
Include the affected version, a description of the problem, and steps to
reproduce it if you have them.

You can expect an acknowledgement within a few days. Once a fix is ready it will
be released and the advisory published with credit to the reporter, unless you
ask to stay anonymous.

## Handling credentials

This SDK deals with OAuth2 access and refresh tokens and with financial data.
A few things worth keeping in mind when you integrate it:

- Access and refresh tokens are secrets. Store them server side, never in client
  code or version control, and never log them.
- Refresh tokens rotate on every use. Persist the new token after each refresh.
- Webhook payloads must be verified with `WebhookVerifier` (HMAC-SHA256) before
  you trust them.
- The OAuth2 `state` parameter and the PKCE code verifier are the consuming
  application's responsibility to generate, store, and validate.
