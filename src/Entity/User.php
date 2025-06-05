<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

/**
 * User entity representing a registered user
 */
final readonly class User
{
    public function __construct(
        private string $name,
        private string $email,
        private string $hashedPassword,
        private DateTimeImmutable $registeredAt
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getRegisteredAt(): DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'hashedPassword' => $this->hashedPassword,
            'registeredAt' => $this->registeredAt->format('Y-m-d H:i:s'),
        ];
    }
}
