<?php

declare(strict_types=1);

namespace Sujip\Xero;

use Sujip\Xero\Accounting\Accounting;
use Sujip\Xero\AppStore\AppStore;
use Sujip\Xero\Assets\Assets;
use Sujip\Xero\Auth\Token;
use Sujip\Xero\Files\Files;
use Sujip\Xero\Finance\Finance;
use Sujip\Xero\Http\NativeTransport;
use Sujip\Xero\Http\PendingRequest;
use Sujip\Xero\Http\Request;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Http\Transport;
use Sujip\Xero\Identity\Identity;
use Sujip\Xero\Payroll\Payroll;
use Sujip\Xero\Projects\Projects;
use Sujip\Xero\Webhooks\Webhooks;

final class Client
{
    private Transport $transport;

    public function __construct(
        private readonly Context $context,
        ?Transport $transport = null
    ) {
        $this->transport = $transport ?? new NativeTransport();
    }

    public function tenant(string $tenantId): self
    {
        return new self($this->context->tenant($tenantId), $this->transport);
    }

    public function withTransport(Transport $transport): self
    {
        return new self($this->context, $transport);
    }

    public function usingNativeTransport(int $timeout = 30, int $connectTimeout = 10): self
    {
        return new self($this->context, new NativeTransport($timeout, $connectTimeout));
    }

    public function withToken(Token $token): self
    {
        return new self(
            Context::make(
                accessToken: $token->getAccessToken(),
                tenantId: $this->context->tenantId,
                baseUri: $this->context->baseUri
            ),
            $this->transport
        );
    }

    public function accounting(): Accounting
    {
        return new Accounting($this);
    }

    public function assets(): Assets
    {
        return new Assets($this);
    }

    public function files(): Files
    {
        return new Files($this);
    }

    public function projects(): Projects
    {
        return new Projects($this);
    }

    public function payroll(): Payroll
    {
        return new Payroll($this);
    }

    public function identity(): Identity
    {
        return new Identity($this);
    }

    public function webhooks(): Webhooks
    {
        return new Webhooks();
    }

    public function finance(): Finance
    {
        return new Finance($this);
    }

    public function appStore(): AppStore
    {
        return new AppStore($this);
    }

    public function context(): Context
    {
        return $this->context;
    }

    public function get(string $path): PendingRequest
    {
        return new PendingRequest($this, 'GET', $path);
    }

    public function post(string $path): PendingRequest
    {
        return new PendingRequest($this, 'POST', $path);
    }

    public function put(string $path): PendingRequest
    {
        return new PendingRequest($this, 'PUT', $path);
    }

    public function patch(string $path): PendingRequest
    {
        return new PendingRequest($this, 'PATCH', $path);
    }

    public function delete(string $path): PendingRequest
    {
        return new PendingRequest($this, 'DELETE', $path);
    }

    public function send(Request $request): Response
    {
        $request = $request->withBaseUri($this->context->baseUri)
            ->mergeHeaders($this->context->authHeaders());

        if ($request->includeTenantHeader) {
            $request = $request->mergeHeaders($this->context->tenantHeaders());
        }

        return $this->transport->send($request);
    }
}
