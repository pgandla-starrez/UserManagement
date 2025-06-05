<?php

declare(strict_types=1);

namespace App\Exception;

use InvalidArgumentException;

/**
 * Exception thrown when attempting to register a user that already exists
 */
final class UserAlreadyExistsException extends InvalidArgumentException
{
}
