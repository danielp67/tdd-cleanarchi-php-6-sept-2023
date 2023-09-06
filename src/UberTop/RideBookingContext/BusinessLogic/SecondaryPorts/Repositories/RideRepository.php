<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories;

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;

interface RideRepository
{
    function save(Ride $ride): void;
}