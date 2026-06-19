<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BrandingTheme;

use Sujip\Xero\Accounting\PaymentService\PaymentService;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class BrandingThemes implements DefinesScopes
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.settings'],
            granular: ['accounting.settings.read', 'accounting.settings']
        );
    }

    /**
     * @return ResourceCollection<BrandingTheme>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/BrandingThemes')
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $brandingTheme): BrandingTheme => $this->mapBrandingTheme($brandingTheme),
            Json::extractList($payload, 'BrandingThemes')
        );

        return new ResourceCollection($items);
    }

    public function find(string $brandingThemeId): ?BrandingTheme
    {
        $response = $this->client
            ->get('/api.xro/2.0/BrandingThemes/' . $brandingThemeId)
            ->send();

        $payload = $response->json();
        $brandingTheme = Json::extractFirst($payload, 'BrandingThemes');

        return $brandingTheme !== null ? $this->mapBrandingTheme($brandingTheme) : null;
    }

    /**
     * @return ResourceCollection<PaymentService>
     */
    public function paymentServices(string $brandingThemeId): ResourceCollection
    {
        $payload = $this->client
            ->get('/api.xro/2.0/BrandingThemes/' . $brandingThemeId . '/PaymentServices')
            ->send()
            ->json();

        return $this->mapPaymentServices($payload);
    }

    /**
     * @return ResourceCollection<PaymentService>
     */
    public function applyPaymentService(string $brandingThemeId, string $paymentServiceId, ?string $idempotencyKey = null): ResourceCollection
    {
        $payload = $this->client
            ->post('/api.xro/2.0/BrandingThemes/' . $brandingThemeId . '/PaymentServices')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson([
                'PaymentServices' => [[
                    'PaymentServiceID' => $paymentServiceId,
                ]],
            ])
            ->send()
            ->json();

        return $this->mapPaymentServices($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapBrandingTheme(array $payload): BrandingTheme
    {
        return (new BrandingTheme())->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     * @return ResourceCollection<PaymentService>
     */
    private function mapPaymentServices(array $payload): ResourceCollection
    {
        $items = array_map(
            static fn (array $paymentService): PaymentService => (new PaymentService())->fill($paymentService),
            Json::extractList($payload, 'PaymentServices')
        );

        return new ResourceCollection($items);
    }
}
