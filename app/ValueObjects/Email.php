<?php

namespace App\ValueObjects;

class Email
{
    public function __construct(
        public readonly string $value,
    ) {
        if (! filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email');
        }

    }
}
