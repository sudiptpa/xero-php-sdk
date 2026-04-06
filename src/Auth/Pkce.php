<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

final class Pkce
{
    public static function verifier(int $length = 64): string
    {
        $length = max(43, min(128, $length));
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~';
        $maxIndex = strlen($alphabet) - 1;
        $verifier = '';

        for ($index = 0; $index < $length; $index++) {
            $verifier .= $alphabet[random_int(0, $maxIndex)];
        }

        return $verifier;
    }

    public static function challenge(string $verifier): string
    {
        return rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');
    }
}
