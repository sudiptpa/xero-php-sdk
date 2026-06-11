<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

use Sujip\Xero\Exceptions\AuthenticationException;
use Sujip\Xero\Exceptions\InsufficientScopeException;
use Sujip\Xero\Exceptions\RateLimitException;
use Sujip\Xero\Exceptions\RequestException;
use Sujip\Xero\Exceptions\ValidationException;

final class ResponseErrorMapper
{
    public static function map(Response $response): RequestException
    {
        $wwwAuthenticate = strtolower($response->header('WWW-Authenticate', '') ?? '');

        if (
            $response->status === 401
            && (
                str_contains($wwwAuthenticate, 'insufficient_scope')
                || str_contains($wwwAuthenticate, 'insufficent_scope')
            )
        ) {
            return new InsufficientScopeException($response, 'Xero rejected the request because the connection is missing a required scope.');
        }

        if ($response->status === 401 || $response->status === 403) {
            return new AuthenticationException($response, 'Xero rejected the request due to an authentication or permission error.');
        }

        if ($response->status === 429) {
            return new RateLimitException($response, 'Xero rate limit reached.');
        }

        if ($response->status === 400 || $response->status === 422) {
            return new ValidationException($response, 'Xero rejected the request payload.');
        }

        return new RequestException($response);
    }
}
