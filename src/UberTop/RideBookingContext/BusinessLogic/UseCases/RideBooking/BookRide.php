<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking;

use App\UberTop\RideBookingContext\BusinessLogic\Models\DateProvider;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;

class BookRide
{

    public function __construct(private readonly RideRepository $rideRepository,
                                private readonly TripScanner    $tripScanner,
                                private readonly DateProvider   $dateProvider)
    {
    }

    public function book(string $departure, string $arrival, bool $wantsUberX): void
    {
        $distance = $this->tripScanner->distance($departure, $arrival);
        $ride = Ride::book(
            "123abc",
            "234def",
            $departure,
            $arrival,
            $distance,
            $wantsUberX,
            $this->dateProvider->now(),
        );
        $this->rideRepository->save($ride);
    }
}