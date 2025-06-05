<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Psr\Log\LoggerInterface;

/**
 * Email-based notification service
 */
class EmailNotificationService implements NotificationServiceInterface
{
    private const ADMIN_EMAIL = 'admin@ourplatform.com';
    private const PLATFORM_NAME = 'OurPlatform';

    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public function sendWelcomeNotification(User $user): void
    {
        $subject = "Welcome to " . self::PLATFORM_NAME . "!";
        $body = $this->createWelcomeEmailBody($user);

        $this->sendEmail($user->getEmail(), $subject, $body);

        $this->logger->info('Welcome email sent', [
            'recipient' => $user->getEmail(),
            'subject' => $subject
        ]);
    }

    public function sendAdminNotification(User $user): void
    {
        $subject = "New User Registration";
        $body = $this->createAdminNotificationBody($user);

        $this->sendEmail(self::ADMIN_EMAIL, $subject, $body);

        $this->logger->info('Admin notification sent', [
            'recipient' => self::ADMIN_EMAIL,
            'newUserEmail' => $user->getEmail()
        ]);
    }

    private function createWelcomeEmailBody(User $user): string
    {
        return sprintf(
            "Hi %s,\n\nWelcome to %s! We are glad to have you.\n\n" .
            "Your account details:\n" .
            "Email: %s\n" .
            "Registered: %s\n\n" .
            "Best regards,\n%s Team",
            $this->sanitizeForEmail($user->getName()),
            self::PLATFORM_NAME,
            $user->getEmail(),
            $user->getRegisteredAt()->format('Y-m-d H:i:s'),
            self::PLATFORM_NAME
        );
    }

    private function createAdminNotificationBody(User $user): string
    {
        return sprintf(
            "A new user has registered:\n\n" .
            "Name: %s\n" .
            "Email: %s\n" .
            "Registration Time: %s",
            $this->sanitizeForEmail($user->getName()),
            $user->getEmail(),
            $user->getRegisteredAt()->format('Y-m-d H:i:s')
        );
    }

    private function sendEmail(string $to, string $subject, string $body): void
    {
        // In a real application, this would use a proper email service
        // For now, we simulate by logging (as per the original requirement)

        // Uncomment the line below to send actual emails when mail() is available
        // mail($to, $subject, $body);

        $this->logger->info('EMAIL_SENT', [
            'to' => $to,
            'subject' => $subject,
            'body_preview' => substr($body, 0, 100) . '...'
        ]);
    }

    private function sanitizeForEmail(string $text): string
    {
        // Remove potential email header injection characters
        return str_replace(["\r", "\n", "\t"], ' ', $text);
    }
}
