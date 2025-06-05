<?php

declare(strict_types=1);

namespace App\Validation;

use App\Exception\ValidationException;

/**
 * Validates user registration data
 */
class UserValidator
{
    private const MIN_PASSWORD_LENGTH = 8;
    private const REQUIRED_FIELDS = ['name', 'email', 'password'];

    public function validate(array $userData): void
    {
        $this->validateRequiredFields($userData);
        $this->validateEmail($userData['email']);
        $this->validatePassword($userData['password']);
        $this->validateName($userData['name']);
    }

    private function validateRequiredFields(array $userData): void
    {
        $missingFields = [];

        foreach (self::REQUIRED_FIELDS as $field) {
            if (empty($userData[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            throw new ValidationException(
                'Missing required fields: ' . implode(', ', $missingFields)
            );
        }
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Invalid email format: {$email}");
        }
    }

    private function validatePassword(string $password): void
    {
        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            throw new ValidationException(
                "Password must be at least " . self::MIN_PASSWORD_LENGTH . " characters long"
            );
        }

        // Additional password strength checks
        if (!preg_match('/[A-Z]/', $password)) {
            throw new ValidationException('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new ValidationException('Password must contain at least one lowercase letter');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new ValidationException('Password must contain at least one number');
        }
    }

    private function validateName(string $name): void
    {
        $name = trim($name);

        if (strlen($name) < 2) {
            throw new ValidationException('Name must be at least 2 characters long');
        }

        if (strlen($name) > 100) {
            throw new ValidationException('Name must be less than 100 characters long');
        }

        // Prevent potential CSV injection
        if (preg_match('/[,"\r\n]/', $name)) {
            throw new ValidationException('Name contains invalid characters');
        }
    }
}
