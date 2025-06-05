<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Service for secure password hashing operations
 */
class PasswordHashingService
{
    private const ALGORITHM = PASSWORD_ARGON2ID;
    private const OPTIONS = [
        'memory_cost' => 65536, // 64 MB
        'time_cost' => 4,       // 4 iterations
        'threads' => 3,         // 3 threads
    ];

    public function hash(string $password): string
    {
        $hashedPassword = password_hash($password, self::ALGORITHM, self::OPTIONS);

        if ($hashedPassword === false) {
            throw new \RuntimeException('Failed to hash password');
        }

        return $hashedPassword;
    }

    public function verify(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return password_needs_rehash($hashedPassword, self::ALGORITHM, self::OPTIONS);
    }
}
