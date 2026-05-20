<?php

namespace App\ValueObjects;

class Price
{
    public function __construct(
        public readonly float $amount,
    ) {
        if ($this->amount < 0) {
            throw new \InvalidArgumentException('Price cannot be negative');
        }
    }

    public function format(): string
    {
        return number_format($this->amount, 2);
    }

    public function equals(Price $other): bool
    {
        return $this->amount === $other->amount;
    }

    public function add(Price $other): Price
    {
        return new Price($this->amount + $other->amount);
    }
}
