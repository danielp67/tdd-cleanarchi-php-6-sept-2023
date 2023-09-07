<?php

namespace App\Tests\UberTop\RideBookingContext\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories;

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class RideRepositoryStub implements RideRepository
{
    private array $rides = [];

    public function save(Ride $ride): void
    {
        $this->rides[$ride->getId()->toString()] = $ride;
    }

    public function byId(UuidInterface $rideId): Ride
    {
        // this is a clone!
        return clone $this->rides[$rideId->toString()];
    }

    public function rides(): array
    {
        // return only array values
        return array_values($this->rides);
    }

    public function feedWith(Ride $ride): void
    {
        $this->save($ride);
    }

}