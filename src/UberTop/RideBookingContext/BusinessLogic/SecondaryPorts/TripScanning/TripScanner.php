<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning;

interface TripScanner
{
    function distance(string $departure, string $arrival): float;
}