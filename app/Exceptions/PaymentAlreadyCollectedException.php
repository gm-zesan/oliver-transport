<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class PaymentAlreadyCollectedException extends Exception
{
    protected $message = 'Cash payment has already been collected for this booking.';
}
