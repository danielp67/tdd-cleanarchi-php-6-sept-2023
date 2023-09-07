<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\TripScanning;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;

class TripScannerStub implements TripScanner
{

    private static array $distances = [];
    private static int $counter = 0;

    function distance(string $departure, string $arrival): float
    {
        return self::$distances[self::$counter++];
    }

    public function setDistances(float ...$distances): void
    {
        self::$distances = $distances;
        self::$counter = 0;
    }

}