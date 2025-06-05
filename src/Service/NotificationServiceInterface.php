<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;

/**
 * Interface for notification services
 */
interface NotificationServiceInterface
{
    /**
     * Send welcome notification to the newly registered user
     */
    public function sendWelcomeNotification(User $user): void;

    /**
     * Send admin notification about new user registration
     */
    public function sendAdminNotification(User $user): void;
}
