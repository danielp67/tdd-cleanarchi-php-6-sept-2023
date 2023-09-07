<?php

declare(strict_types=1);

namespace App\UberTop\RideBookingContext\Adapters\Secondary\UuidGenerating;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

final class RandomUuidGenerator implements \App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\UuidGenerating\UuidGenerator
{
    public function generateV4(): UuidInterface
    {
        return UuidV4::uuid4();
    }
}