<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthorizationException extends HttpException implements Responsable
{
    /**
     * @param string[] $headers
     */
    public function __construct(?string $message = null, \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(403, $message ?? 'Not authorized', $previous, $headers, $code);
    }

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(['error' => $this->getMessage()], $this->getStatusCode());
    }
}
