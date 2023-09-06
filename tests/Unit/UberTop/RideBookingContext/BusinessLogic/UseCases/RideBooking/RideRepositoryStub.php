<?php

namespace App\Tests\Unit\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking;

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\RideRepository;

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