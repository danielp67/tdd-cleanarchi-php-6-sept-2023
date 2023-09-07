<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\UuidGeneration;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\UuidGeneration\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

class DeterministicUuidGenerator implements UuidGenerator
{
    private static array $nextUuids = [];
    private static int $counter = 0;

    public function generate(): UuidInterface
    {
        return self::$nextUuids[self::$counter++];
    }

    public function setNextUuids(UuidInterface ...$nextUuids): void
    {
        self::$nextUuids = $nextUuids;
        self::$counter = 0;
    }
}