<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation;

use Ramsey\Uuid\UuidInterface;

class CancelRideCommand
{
    public function __construct(public UuidInterface $rideId)
    {
    }
}