<?php

declare(strict_types=1);

namespace StudentsGradesApi\Infrastructure\HttpApi\Symfony\Response;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use StudentsGradesApi\Application\Command\CommandResponseInterface;
use StudentsGradesApi\Application\Exception\InvalidGradeException;
use StudentsGradesApi\Application\Exception\StudentNotFoundException;
use StudentsGradesApi\Infrastructure\HttpApi\Symfony\Exception\UnmanagedHttpApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

final class JsonResponseFactory
{
    public static function fromCommandReponse(CommandResponseInterface $commandResponse, int $responseStatusCode): JsonResponse
    {
        return new JsonResponse(['uuid' => $commandResponse->getValue()], $responseStatusCode);
    }

    /**
     * @param array<int, mixed> $viewModel
     */
    public static function fromViewModel(array $viewModel): JsonResponse
    {
        return new JsonResponse($viewModel, Response::HTTP_OK);
    }

    public static function fromException(\Exception $e): JsonResponse
    {
        return match ($exceptionClass = get_class($e)) {
            InvalidGradeException::class,
            InvalidUuidStringException::class,
            \JsonException::class,
            MissingConstructorArgumentsException::class,
            NotEncodableValueException::class,
            NotNormalizableValueException::class => self::buildBadRequestJsonResponse($e->getMessage()),

            StudentNotFoundException::class => self::buildNotFoundJsonResponse(),
            default => throw new UnmanagedHttpApiException(sprintf('%s exception class in not managed', $exceptionClass)) };
    }

    private static function buildBadRequestJsonResponse(string $exceptionMessage): JsonResponse
    {
        return new JsonResponse(['message' => $exceptionMessage], Response::HTTP_BAD_REQUEST);
    }

    private static function buildNotFoundJsonResponse(): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
