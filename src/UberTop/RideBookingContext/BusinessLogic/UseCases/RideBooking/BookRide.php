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

    public function book(string $departure, string $arrival, bool $hasUberX): void
    {
        $distance = $this->tripScanner->distance($departure, $arrival);

        $price = 10 + $distance * 0.5;

        if ($hasUberX) {
            $price += 5;
        }

        $this->rideRepository->save(new Ride(
            "123abc",
            "234def",
            $departure,
            $arrival,
            $price
        ));
    }
}