<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UnauthorizedTokenException extends UnauthorizedHttpException
{
    public function __construct(string $message = null)
    {
        parent::__construct('Bearer', $message);
    }

    public function render($request)
    {
        $message = $this->getMessage();
        $statusCode = $this->getStatusCode();

        $error = 'invalid_client';
        if ($message === 'Token has expired') {
            $error = 'invalid_token';
        }

        return response([
                'error' => $error,
                'error_description' => $message,
            ], $statusCode)
            ->withHeaders([
                'Cache-Control' =>'no-store',
                'Pragma' => 'no-cache',
            ]);
    }
}
