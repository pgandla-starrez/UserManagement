<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\StorageException;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;

/**
 * File-based implementation of user storage
 */
class FileUserRepository implements UserRepositoryInterface
{
    private const FILE_NAME = 'users.txt';
    private const FIELD_SEPARATOR = '|'; // Using pipe instead of comma to prevent CSV injection

    public function __construct(
        private readonly string $dataDirectory,
        private readonly LoggerInterface $logger
    ) {
        $this->ensureDataDirectoryExists();
    }

    public function save(User $user): void
    {
        $filePath = $this->getFilePath();

        try {
            // Create record with proper escaping
            $record = $this->createRecord($user);

            $fileHandle = fopen($filePath, 'a');
            if ($fileHandle === false) {
                throw new StorageException("Cannot open file for writing: {$filePath}");
            }

            if (flock($fileHandle, LOCK_EX)) {
                fwrite($fileHandle, $record . PHP_EOL);
                flock($fileHandle, LOCK_UN);
                fclose($fileHandle);

                $this->logger->info('User registered successfully', [
                    'email' => $user->getEmail(),
                    'registeredAt' => $user->getRegisteredAt()->format('Y-m-d H:i:s')
                ]);
            } else {
                fclose($fileHandle);
                throw new StorageException('Cannot acquire file lock for writing');
            }
        } catch (\Throwable $e) {
            $this->logger->error('Failed to save user', [
                'email' => $user->getEmail(),
                'error' => $e->getMessage()
            ]);
            throw new StorageException('Failed to save user: ' . $e->getMessage(), 0, $e);
        }
    }

    public function existsByEmail(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    public function findByEmail(string $email): ?User
    {
        $filePath = $this->getFilePath();

        if (!file_exists($filePath)) {
            return null;
        }

        try {
            $content = file_get_contents($filePath);
            if ($content === false) {
                throw new StorageException("Cannot read file: {$filePath}");
            }

            $lines = explode(PHP_EOL, trim($content));

            foreach ($lines as $line) {
                if (empty($line)) {
                    continue;
                }

                $user = $this->parseRecord($line);
                if ($user && $user->getEmail() === $email) {
                    return $user;
                }
            }

            return null;
        } catch (\Throwable $e) {
            $this->logger->error('Failed to find user by email', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            throw new StorageException('Failed to find user: ' . $e->getMessage(), 0, $e);
        }
    }

    private function createRecord(User $user): string
    {
        return implode(self::FIELD_SEPARATOR, [
            $this->escapeField($user->getName()),
            $this->escapeField($user->getEmail()),
            $this->escapeField($user->getHashedPassword()),
            $this->escapeField($user->getRegisteredAt()->format('Y-m-d H:i:s'))
        ]);
    }

    private function parseRecord(string $record): ?User
    {
        $fields = explode(self::FIELD_SEPARATOR, $record);

        if (count($fields) !== 4) {
            return null;
        }

        try {
            return new User(
                $this->unescapeField($fields[0]),
                $this->unescapeField($fields[1]),
                $this->unescapeField($fields[2]),
                new DateTimeImmutable($this->unescapeField($fields[3]))
            );
        } catch (\Throwable) {
            return null;
        }
    }

    private function escapeField(string $field): string
    {
        // Simple escaping for pipe-separated format
        return str_replace(self::FIELD_SEPARATOR, '\\' . self::FIELD_SEPARATOR, $field);
    }

    private function unescapeField(string $field): string
    {
        return str_replace('\\' . self::FIELD_SEPARATOR, self::FIELD_SEPARATOR, $field);
    }

    private function getFilePath(): string
    {
        return $this->dataDirectory . DIRECTORY_SEPARATOR . self::FILE_NAME;
    }

    private function ensureDataDirectoryExists(): void
    {
        if (!is_dir($this->dataDirectory)) {
            if (!mkdir($this->dataDirectory, 0755, true)) {
                throw new StorageException("Cannot create data directory: {$this->dataDirectory}");
            }
        }
    }
}
