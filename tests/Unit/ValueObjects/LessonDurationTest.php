<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\LessonDuration;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LessonDurationTest extends TestCase
{
    public function test_it_stores_seconds(): void
    {
        $duration = new LessonDuration(90);

        $this->assertSame(90, $duration->seconds);
    }

    public function test_it_rejects_negative_seconds(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Duration cannot be negative');

        new LessonDuration(-5);
    }

    public function test_it_allows_zero_seconds(): void
    {
        $duration = new LessonDuration(0);

        $this->assertSame(0, $duration->seconds);
    }

    public function test_in_minutes_converts_seconds_correctly(): void
    {
        $duration = new LessonDuration(150);

        $this->assertSame(2.5, $duration->inMinutes());
    }

    public function test_format_returns_mm_ss(): void
    {
        $duration = new LessonDuration(125);

        $this->assertSame('02:05', $duration->format());
    }

    public function test_format_pads_single_digit_seconds(): void
    {
        $duration = new LessonDuration(65);

        $this->assertSame('01:05', $duration->format());
    }

    public function test_equals_returns_true_for_same_duration(): void
    {
        $a = new LessonDuration(60);
        $b = new LessonDuration(60);

        $this->assertTrue($a->equals($b));
    }

    public function test_equals_returns_false_for_different_duration(): void
    {
        $a = new LessonDuration(60);
        $b = new LessonDuration(120);

        $this->assertFalse($a->equals($b));
    }

    public function test_add_returns_a_new_immutable_instance(): void
    {
        $a = new LessonDuration(60);
        $b = new LessonDuration(30);

        $result = $a->add($b);

        $this->assertInstanceOf(LessonDuration::class, $result);
        $this->assertSame(90, $result->seconds);
        $this->assertSame(60, $a->seconds);
    }
}
