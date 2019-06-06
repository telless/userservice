<?php

namespace App\Application\Common;

final class ApplicationResponse
{
    private $success;
    private $data;
    private $errors;

    /*
     * TODO psalm-template for data
     */
    private function __construct(bool $success, $data, ?array $errors)
    {
        $this->success = $success;
        $this->data = $data;
        $this->errors = $errors;
    }

    public static function generateErrorResponse(array $errors): self
    {
        return new self(false, null, $errors);
    }

    public static function generateSuccessResponse($data): self
    {
        return new self(true, $data, null);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    // TODO psalm-template
    public function data()
    {
        return $this->data;
    }

    public function errors(): ?array
    {
        return $this->errors;
    }

    public function errorsAsString(): string
    {
        return implode(',', $this->errors ?? []);
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