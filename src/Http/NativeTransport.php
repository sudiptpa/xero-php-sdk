<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

use Sujip\Xero\Exceptions\TransportException;

final class NativeTransport implements Transport
{
    public function __construct(
        private readonly int $timeout = 30,
        private readonly int $connectTimeout = 10
    ) {
    }

    public function send(Request $request): Response
    {
        if (!function_exists('curl_init')) {
            throw new TransportException('The curl extension is required for NativeTransport.');
        }

        $handle = curl_init();

        if ($handle === false) {
            throw new TransportException('Unable to initialize curl.');
        }

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
            curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($request->json, JSON_THROW_ON_ERROR));
        } elseif ($request->body !== null) {
            curl_setopt($handle, CURLOPT_POSTFIELDS, $request->body);
        }

        $body = curl_exec($handle);

        if ($body === false) {
            $message = curl_error($handle);
            curl_close($handle);

            throw new TransportException($message !== '' ? $message : 'Unknown transport error.');
        }

        if (! is_string($body)) {
            curl_close($handle);

            throw new TransportException('Unexpected curl response body type.');
        }

        $status = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        curl_close($handle);

        $response = new Response($status, $responseHeaders, $body);

        if ($status >= 400) {
            throw ResponseErrorMapper::map($response);
        }

        return $response;
    }
}
