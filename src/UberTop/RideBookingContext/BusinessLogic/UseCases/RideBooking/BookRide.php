<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking;

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;

class BookRide
{

    public function __construct(private readonly RideRepository $rideRepository,
                                private readonly TripScanner    $tripScanner)
    {
    }

    public function book(string $departure, string $arrival): void
    {
        $distance = $this->tripScanner->distance($departure, $arrival);
        $this->rideRepository->save(new Ride(
            "123abc",
            "234def",
            $departure,
            $arrival,
            10 + $distance * 0.5
        ));
    }
}