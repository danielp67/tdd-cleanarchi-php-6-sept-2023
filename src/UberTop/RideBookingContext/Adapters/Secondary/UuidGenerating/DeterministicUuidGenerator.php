<?php

declare(strict_types=1);

namespace App\UberTop\RideBookingContext\Adapters\Secondary\UuidGenerating;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\UuidGenerating\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

final class DeterministicUuidGenerator implements UuidGenerator
{
    private array $uuids = [];

    public function generateV4(): UuidInterface
    {
        return array_shift($this->uuids);
    }

    public function nextUuids(UuidInterface ...$uuidV4): void
    {
        $this->uuids = $uuidV4;
    }
}