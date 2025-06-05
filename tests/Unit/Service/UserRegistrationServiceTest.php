<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Exception\ValidationException;
use App\Repository\UserRepositoryInterface;
use App\Service\NotificationServiceInterface;
use App\Service\PasswordHashingService;
use App\Service\UserRegistrationService;
use App\Validation\UserValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class UserRegistrationServiceTest extends TestCase
{
    private UserValidator&MockObject $validator;
    private PasswordHashingService&MockObject $passwordHasher;
    private UserRepositoryInterface&MockObject $userRepository;
    private NotificationServiceInterface&MockObject $notificationService;
    private LoggerInterface&MockObject $logger;
    private UserRegistrationService $service;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(UserValidator::class);
        $this->passwordHasher = $this->createMock(PasswordHashingService::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->notificationService = $this->createMock(NotificationServiceInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->service = new UserRegistrationService(
            $this->validator,
            $this->passwordHasher,
            $this->userRepository,
            $this->notificationService,
            $this->logger
        );
    }

    public function testRegisterUserSuccessfully(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'SecurePass123'
        ];

        $this->validator->expects($this->once())->method('validate')->with($userData);
        $this->userRepository->expects($this->once())->method('existsByEmail')->willReturn(false);
        $this->passwordHasher->expects($this->once())->method('hash')->willReturn('$hashed$');
        $this->userRepository->expects($this->once())->method('save');
        $this->notificationService->expects($this->once())->method('sendWelcomeNotification');
        $this->notificationService->expects($this->once())->method('sendAdminNotification');

        $result = $this->service->registerUser($userData);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('John Doe', $result->getName());
    }

    public function testRegisterUserThrowsExceptionWhenUserExists(): void
    {
        $userData = ['name' => 'John', 'email' => 'existing@test.com', 'password' => 'Pass123'];

        $this->validator->method('validate');
        $this->userRepository->method('existsByEmail')->willReturn(true);

        $this->expectException(UserAlreadyExistsException::class);
        $this->service->registerUser($userData);
    }
}
