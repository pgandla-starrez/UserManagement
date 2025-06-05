<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

/**
 * Interface for user storage operations
 */
interface UserRepositoryInterface
{
    /**
     * Save a user to storage
     */
    public function save(User $user): void;

    /**
     * Check if a user exists by email
     */
    public function existsByEmail(string $email): bool;

    /**
     * Find a user by email
     */
    public function findByEmail(string $email): ?User;
}
