<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\TripScanning;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;

class FakeTripScanner implements TripScanner
{

    private float $distance = 0;

    function distance(string $departure, string $arrival): float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

}