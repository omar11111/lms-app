<?php
namespace App\ValueObjects;

class LessonDuration
{
    public function __construct(
        public readonly int $seconds,
    ) {
        if ($this->seconds < 0) {
            throw new \InvalidArgumentException('Duration cannot be negative');
        }
    }

    public function inMinutes(): float
    {
        return $this->seconds / 60;
    }

    public function format(): string
    {
        $minutes = floor($this->seconds / 60);
        $seconds = $this->seconds % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function equals(Duration $other): bool
    {
        return $this->seconds === $other->seconds;
    }

    public function add(Duration $other): Duration
    {
        return new Duration($this->seconds + $other->seconds);
    }
}
