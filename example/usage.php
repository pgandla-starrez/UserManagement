<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Repository\FileUserRepository;
use App\Service\EmailNotificationService;
use App\Service\PasswordHashingService;
use App\Service\UserRegistrationService;
use App\Validation\UserValidator;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create logger
$logger = new Logger('user_management');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));

// Create dependencies
$validator = new UserValidator();
$passwordHasher = new PasswordHashingService();
$userRepository = new FileUserRepository(__DIR__ . '/../data', $logger);
$notificationService = new EmailNotificationService($logger);

// Create main service
$userRegistrationService = new UserRegistrationService(
    $validator,
    $passwordHasher,
    $userRepository,
    $notificationService,
    $logger
);

// Example 1: Successful registration
try {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => 'SecurePassword123'
    ];

    $user = $userRegistrationService->registerUser($userData);
    echo "✅ User registered successfully: {$user->getEmail()}\n";

} catch (\Exception $e) {
    echo "❌ Registration failed: {$e->getMessage()}\n";
}

// Example 2: Validation error
try {
    $invalidUserData = [
        'name' => 'Jane Doe',
        'email' => 'invalid-email', // Invalid email format
        'password' => 'weak'        // Weak password
    ];

    $userRegistrationService->registerUser($invalidUserData);

} catch (\Exception $e) {
    echo "❌ Expected validation error: {$e->getMessage()}\n";
}

// Example 3: Check if user exists
$exists = $userRegistrationService->userExists('john.doe@example.com');
echo $exists ? "✅ User exists\n" : "❌ User does not exist\n";

// Example 4: Attempt duplicate registration
try {
    $duplicateUserData = [
        'name' => 'John Doe Again',
        'email' => 'john.doe@example.com', // Same email as above
        'password' => 'AnotherPassword123'
    ];

    $userRegistrationService->registerUser($duplicateUserData);

} catch (\Exception $e) {
    echo "❌ Expected duplicate error: {$e->getMessage()}\n";
}
