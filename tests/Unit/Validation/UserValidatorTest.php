<?php

declare(strict_types=1);

namespace Tests\Unit\Validation;

use App\Exception\ValidationException;
use App\Validation\UserValidator;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for UserValidator
 */
class UserValidatorTest extends TestCase
{
    private UserValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new UserValidator();
    }

    public function testValidateWithValidData(): void
    {
        $validData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'SecurePass123'
        ];

        // Should not throw any exception
        $this->validator->validate($validData);
        $this->assertTrue(true); // If we reach here, validation passed
    }

    public function testValidateThrowsExceptionForMissingEmail(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Missing required fields: email');

        $this->validator->validate([
            'name' => 'John Doe',
            'password' => 'SecurePass123'
        ]);
    }

    public function testValidateThrowsExceptionForMissingMultipleFields(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Missing required fields: name, email');

        $this->validator->validate([
            'password' => 'SecurePass123'
        ]);
    }

    public function testValidateThrowsExceptionForInvalidEmail(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Invalid email format: invalid-email');

        $this->validator->validate([
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'SecurePass123'
        ]);
    }

    public function testValidateThrowsExceptionForShortPassword(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Password must be at least 8 characters long');

        $this->validator->validate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'short'
        ]);
    }

    public function testValidateThrowsExceptionForPasswordWithoutUppercase(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Password must contain at least one uppercase letter');

        $this->validator->validate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'nouppercase123'
        ]);
    }

    public function testValidateThrowsExceptionForPasswordWithoutLowercase(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Password must contain at least one lowercase letter');

        $this->validator->validate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'NOLOWERCASE123'
        ]);
    }

    public function testValidateThrowsExceptionForPasswordWithoutNumber(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Password must contain at least one number');

        $this->validator->validate([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'NoNumbersHere'
        ]);
    }

    public function testValidateThrowsExceptionForShortName(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Name must be at least 2 characters long');

        $this->validator->validate([
            'name' => 'J',
            'email' => 'john.doe@example.com',
            'password' => 'SecurePass123'
        ]);
    }

    public function testValidateThrowsExceptionForNameWithInvalidCharacters(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Name contains invalid characters');

        $this->validator->validate([
            'name' => 'John,Doe', // Contains comma which could cause CSV injection
            'email' => 'john.doe@example.com',
            'password' => 'SecurePass123'
        ]);
    }
}
