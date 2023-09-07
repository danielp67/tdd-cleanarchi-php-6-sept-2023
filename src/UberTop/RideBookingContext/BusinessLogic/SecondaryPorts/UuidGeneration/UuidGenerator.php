<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\UuidGeneration;

use Ramsey\Uuid\UuidInterface;

interface UuidGenerator
{
    public function generate(): UuidInterface;
}