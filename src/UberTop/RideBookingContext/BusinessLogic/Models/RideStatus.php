<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

enum RideStatus: string
{
    case WAITING_FOR_DRIVER = 'WAITING_FOR_DRIVER';
    case CANCELLED = 'CANCELLED';
}