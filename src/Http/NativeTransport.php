<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

use Sujip\Xero\Exceptions\TransportException;
use Sujip\Xero\Support\Json;

final class NativeTransport implements Transport
{
    public function __construct(
        private readonly int $timeout = 30,
        private readonly int $connectTimeout = 10
    ) {
    }

    public function send(Request $request): Response
    {
        // @codeCoverageIgnoreStart
        // The curl extension is a hard requirement and curl_init() effectively
        // never returns false on a supported build, so these guards are unreachable in tests.
        if (!function_exists('curl_init')) {
            throw new TransportException('The curl extension is required for NativeTransport.');
        }

        $handle = curl_init();

        if ($handle === false) {
            throw new TransportException('Unable to initialize curl.');
        }
        // @codeCoverageIgnoreEnd

        $headers = [];

        foreach ($request->headers as $name => $value) {
            $headers[] = $name . ': ' . $value;
        }

        if ($request->json !== null) {
            $headers[] = 'Content-Type: application/json';
        }

        $responseHeaders = [];

        curl_setopt_array($handle, [
            CURLOPT_URL => $request->url(),
            CURLOPT_CUSTOMREQUEST => $request->method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HEADERFUNCTION => static function ($curl, string $header) use (&$responseHeaders): int {
                $length = strlen($header);
                $parts = explode(':', $header, 2);

                if (count($parts) === 2) {
                    $responseHeaders[trim($parts[0])] = trim($parts[1]);
                }

                return $length;
            },
        ]);

        if ($request->json !== null) {
            curl_setopt($handle, CURLOPT_POSTFIELDS, Json::encode($request->json));
        } elseif ($request->body !== null) {
            curl_setopt($handle, CURLOPT_POSTFIELDS, $request->body);
        }

        $body = curl_exec($handle);

        if ($body === false) {
            $message = curl_error($handle);

            throw new TransportException($message !== '' ? $message : 'Unknown transport error.');
        }

        // @codeCoverageIgnoreStart
        // CURLOPT_RETURNTRANSFER guarantees a string on success, so a non-string,
        // non-false body is unreachable on a sane PHP+curl build.
        if (! is_string($body)) {
            throw new TransportException('Unexpected curl response body type.');
        }
        // @codeCoverageIgnoreEnd

        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);

        // curl_close() has been a no-op since PHP 8.0 (the CurlHandle is freed by
        // the garbage collector) and is deprecated from 8.5, so it is intentionally omitted.
        $response = new Response($status, $responseHeaders, $body);

        if ($status >= 400) {
            throw ResponseErrorMapper::map($response);
        }

        return $response;
    }
}
