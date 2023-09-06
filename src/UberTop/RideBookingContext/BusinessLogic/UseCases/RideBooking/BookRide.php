<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking;

use App\Tests\Unit\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking\RideRepositoryStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\RideRepository;

class BookRide
{

    public function __construct(private readonly RideRepository $rideRepository) {}

    public function book(): void
    {
        $this->rideRepository->save(new Ride(
            "123abc",
            "234def",
            "8 avenue Foch Paris",
            "8 avenue Foch Paris",
            10
        ));
    }
}