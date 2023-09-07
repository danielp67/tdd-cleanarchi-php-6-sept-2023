<?php

declare(strict_types=1);

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

enum RideStatus
{
    case CANCELLED;
    case WAITING_FOR_DRIVER;
    case FINISHED;
}
