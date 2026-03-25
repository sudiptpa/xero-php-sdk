<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

interface Transport
{
    public function send(Request $request): Response;
}
