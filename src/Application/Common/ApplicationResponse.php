<?php

namespace App\Application\Common;

/**
 * @template TValue
 */
final class ApplicationResponse
{
    /** @var bool */
    private $success;
    /** @psalm-var TValue */
    private $data;
    /** @var array  */
    private $errors;

    /**
     * @param bool $success
     * @param array<int, string> $errors
     * @param mixed $data
     * @psalm-param TValue $data
     */
    private function __construct(bool $success, $data, array $errors)
    {
        $this->success = $success;
        $this->data = $data;
        $this->errors = $errors;
    }

    public static function generateErrorResponse(array $errors): self
    {
        return new self(false, null, $errors);
    }

    /**
     * @param mixed $data
     * @psalm-param TValue $data
     *
     * @return ApplicationResponse
     */
    public static function generateSuccessResponse($data): self
    {
        return new self(true, $data, []);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @psalm-return TValue
     */
    public function data()
    {
        return $this->data;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function errorsAsString(): string
    {
        return implode(',', $this->errors);
    }

    public function normalize(): array
    {
        return [
            'success' => $this->success,
            'data' => $this->data,
            'errors' => $this->errors,
        ];
    }
}