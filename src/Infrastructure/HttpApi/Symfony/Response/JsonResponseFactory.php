<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response;

use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Exception\UnmanagedHttpApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

final class JsonResponseFactory
{
    public static function fromCommandReponse(CommandResponseInterface $commandResponse, int $responseStatusCode): JsonResponse
    {
        return new JsonResponse(['uuid' => $commandResponse->getValue()], $responseStatusCode);
    }

    public static function fromException(\Exception $e): JsonResponse
    {
        return match ($exceptionClass = get_class($e)) {
            MissingConstructorArgumentsException::class, NotEncodableValueException::class => self::buildBadRequestJsonResponse($e->getMessage()),
            default => throw new UnmanagedHttpApiException(sprintf('%s exception class in not managed', $exceptionClass)) };
    }

    private static function buildBadRequestJsonResponse(string $exceptionMessage): JsonResponse
    {
        return new JsonResponse(['message' => $exceptionMessage], Response::HTTP_BAD_REQUEST);
    }
}
