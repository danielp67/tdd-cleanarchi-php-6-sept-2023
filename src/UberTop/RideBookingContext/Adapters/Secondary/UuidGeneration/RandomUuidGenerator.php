<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\UuidGeneration;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\UuidGeneration\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RandomUuidGenerator implements UuidGenerator
{

    public function generate(): UuidInterface
    {
        return Uuid::uuid4();
    }

}