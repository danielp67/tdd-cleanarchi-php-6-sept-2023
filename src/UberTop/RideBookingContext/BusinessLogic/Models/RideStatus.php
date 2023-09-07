<?php

declare(strict_types=1);

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

enum RideStatus : string
{
    case CANCELLED = 'CANCELLED';
    case WAITING_FOR_DRIVER = 'WAITING_FOR_DRIVER';
    case FINISHED = 'FINISHED';
}
