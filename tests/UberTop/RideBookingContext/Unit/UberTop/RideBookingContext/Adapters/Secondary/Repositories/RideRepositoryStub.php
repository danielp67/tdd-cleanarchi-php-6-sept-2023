<?php

namespace App\Tests\UberTop\RideBookingContext\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories;

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;

class RideRepositoryStub implements RideRepository
{
    private array $rides = [];

    public function save(Ride $ride): void
    {
        $this->rides[] = $ride;
    }

    public function rides(): array
    {
        return $this->rides;
    }


}