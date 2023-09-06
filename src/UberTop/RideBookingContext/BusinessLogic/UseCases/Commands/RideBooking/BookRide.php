<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideBooking;

use App\UberTop\RideBookingContext\BusinessLogic\Models\DateProvider;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class BookRide
{

    public function __construct(private readonly RideRepository $rideRepository,
                                private readonly TripScanner    $tripScanner,
                                private readonly DateProvider   $dateProvider)
    {
    }

    public function book(UuidInterface $riderId, string $departure, string $arrival, bool $wantsUberX): void
    {
        $distance = $this->tripScanner->distance($departure, $arrival);
        $ride = Ride::book(
            UuidV4::fromString("a56ee94f-799a-46eb-97b2-2e5dece46339"),
            $riderId,
            $departure,
            $arrival,
            $distance,
            $wantsUberX,
            $this->dateProvider->now(),
        );
        $this->rideRepository->save($ride);
    }
}