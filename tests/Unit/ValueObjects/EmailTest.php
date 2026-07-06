<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Email;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function test_it_accepts_a_valid_email(): void
    {
        $email = new Email('omar@example.com');

        $this->assertSame('omar@example.com', $email->value);
    }

    public function test_it_rejects_an_invalid_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email');

        new Email('not-an-email');
    }

    public function test_it_rejects_an_empty_string(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Email('');
    }

    #[DataProvider('invalidEmailProvider')]
    public function test_it_rejects_various_malformed_emails(string $invalid): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Email($invalid);
    }

    public static function invalidEmailProvider(): array
    {
        return [
            'missing @' => ['omar.example.com'],
            'missing domain' => ['omar@'],
            'missing local part' => ['@example.com'],
            'double @' => ['omar@@example.com'],
            'spaces' => ['omar ashraf@example.com'],
        ];
    }
}
