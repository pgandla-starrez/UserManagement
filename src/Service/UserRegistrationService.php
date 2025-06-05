<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Repository\UserRepositoryInterface;
use App\Validation\UserValidator;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;

/**
 * Main service for user registration workflow
 */
class UserRegistrationService
{
    public function __construct(
        private readonly UserValidator $validator,
        private readonly PasswordHashingService $passwordHasher,
        private readonly UserRepositoryInterface $userRepository,
        private readonly NotificationServiceInterface $notificationService,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Register a new user and send notifications
     *
     * @param array $userData Array containing 'name', 'email', 'password'
     * @throws ValidationException If validation fails
     * @throws UserAlreadyExistsException If user already exists
     * @throws StorageException If storage fails
     */
    public function registerUser(array $userData): User
    {
        $this->logger->info('Starting user registration process', [
            'email' => $userData['email'] ?? 'unknown'
        ]);

        // Step 1: Validate input data
        $this->validator->validate($userData);

        // Step 2: Check if user already exists
        if ($this->userRepository->existsByEmail($userData['email'])) {
            $this->logger->warning('Attempted registration with existing email', [
                'email' => $userData['email']
            ]);
            throw new UserAlreadyExistsException("User with email {$userData['email']} already exists");
        }

        // Step 3: Hash password securely
        $hashedPassword = $this->passwordHasher->hash($userData['password']);

        // Step 4: Create user entity
        $user = new User(
            name: trim($userData['name']),
            email: $userData['email'],
            hashedPassword: $hashedPassword,
            registeredAt: new DateTimeImmutable()
        );

        // Step 5: Save user to storage
        $this->userRepository->save($user);

        // Step 6: Send notifications
        try {
            $this->notificationService->sendWelcomeNotification($user);
            $this->notificationService->sendAdminNotification($user);
        } catch (\Throwable $e) {
            // Log notification failures but don't fail the registration
            $this->logger->error('Failed to send notifications', [
                'email' => $user->getEmail(),
                'error' => $e->getMessage()
            ]);
        }

        $this->logger->info('User registration completed successfully', [
            'email' => $user->getEmail(),
            'registeredAt' => $user->getRegisteredAt()->format('Y-m-d H:i:s')
        ]);

        return $user;
    }

    /**
     * Check if a user exists by email
     */
    public function userExists(string $email): bool
    {
        return $this->userRepository->existsByEmail($email);
    }
}
