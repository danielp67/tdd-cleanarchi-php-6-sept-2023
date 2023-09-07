<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories;

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use Ramsey\Uuid\UuidInterface;

interface RideRepository
{
    function save(Ride $ride): void;

    public function byId(UuidInterface $rideId): Ride;
}