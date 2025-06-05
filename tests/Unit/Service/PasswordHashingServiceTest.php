<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Service\PasswordHashingService;
use PHPUnit\Framework\TestCase;

class PasswordHashingServiceTest extends TestCase
{
    private PasswordHashingService $service;

    protected function setUp(): void
    {
        $this->service = new PasswordHashingService();
    }

    public function testHashCreatesValidHash(): void
    {
        $password = 'SecurePassword123';
        $hash = $this->service->hash($password);

        $this->assertNotEmpty($hash);
        $this->assertNotEquals($password, $hash);
        $this->assertTrue(password_verify($password, $hash));
    }

    public function testVerifyReturnsTrueForCorrectPassword(): void
    {
        $password = 'SecurePassword123';
        $hash = $this->service->hash($password);

        $this->assertTrue($this->service->verify($password, $hash));
    }

    public function testVerifyReturnsFalseForIncorrectPassword(): void
    {
        $password = 'SecurePassword123';
        $wrongPassword = 'WrongPassword456';
        $hash = $this->service->hash($password);

        $this->assertFalse($this->service->verify($wrongPassword, $hash));
    }

    public function testNeedsRehashReturnsFalseForCurrentHash(): void
    {
        $password = 'SecurePassword123';
        $hash = $this->service->hash($password);

        $this->assertFalse($this->service->needsRehash($hash));
    }
}
