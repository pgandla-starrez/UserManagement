<?php

declare(strict_types=1);

namespace App\Exception;

use InvalidArgumentException;

/**
 * Exception thrown when user data validation fails
 */
final class ValidationException extends InvalidArgumentException
{
}
