<?php

declare(strict_types=1);

namespace Sujip\Xero\Exceptions;

use Sujip\Xero\Http\Response;

class RequestException extends XeroException
{
    public function __construct(
        public readonly Response $response,
        string $message = 'Xero request failed.'
    ) {
        parent::__construct($message, $response->status);
    }
}
