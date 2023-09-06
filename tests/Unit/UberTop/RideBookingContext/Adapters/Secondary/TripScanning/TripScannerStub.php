<?php

namespace App\Tests\Unit\UberTop\RideBookingContext\Adapters\Secondary\TripScanning;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;

class TripScannerStub implements TripScanner
{

    private float $distance;

    function distance(string $departure, string $arrival): float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

}