<?php

namespace Search\Core\Error;

class AppError implements \JsonSerializable
{
    public function __construct(
        private string $message,
        private int $code
    ) {}

    public static function makeBadRequestError(string $message): static
    {
        return new static($message, ErrorCodes::BAD_REQUEST);
    }

    public static function makeInternalError(string $message): static
    {
        return new static($message, ErrorCodes::INTERNAL_ERROR);
    }

    public function jsonSerialize(): array
    {
        return [
            'error' => true,
            'message' => $this->message,
            'code' => $this->code,
        ];
    }

    public function __toString(): string
    {
        return "Error[{$this->code}]: {$this->message}";
    }
}