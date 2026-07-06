<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Price;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function test_it_stores_a_valid_amount(): void
    {
        $price = new Price(99.99);

        $this->assertSame(99.99, $price->amount);
    }

    public function test_it_allows_zero(): void
    {
        $price = new Price(0);

        $this->assertSame(0.0, $price->amount);
    }

    public function test_it_rejects_a_negative_amount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Price cannot be negative');

        new Price(-10);
    }

    public function test_format_returns_two_decimal_places(): void
    {
        $price = new Price(1500);

        $this->assertSame('1,500.00', $price->format());
    }

    public function test_equals_returns_true_for_same_amount(): void
    {
        $a = new Price(49.99);
        $b = new Price(49.99);

        $this->assertTrue($a->equals($b));
    }

    public function test_equals_returns_false_for_different_amount(): void
    {
        $a = new Price(49.99);
        $b = new Price(59.99);

        $this->assertFalse($a->equals($b));
    }

    public function test_add_returns_a_new_price_instance_with_summed_amount(): void
    {
        $a = new Price(50);
        $b = new Price(25.50);

        $result = $a->add($b);

        $this->assertInstanceOf(Price::class, $result);
        $this->assertSame(75.50, $result->amount);
        // add() لازم يكون immutable - مايغيرش القيمة الأصلية
        $this->assertSame(50.0, $a->amount);
    }
}
