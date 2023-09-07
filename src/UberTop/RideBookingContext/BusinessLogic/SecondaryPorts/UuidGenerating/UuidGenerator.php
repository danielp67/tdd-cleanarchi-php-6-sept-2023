<?php

declare(strict_types=1);

namespace App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\UuidGenerating;

use Ramsey\Uuid\UuidInterface;

interface UuidGenerator
{
    public function generateV4(): UuidInterface;
}