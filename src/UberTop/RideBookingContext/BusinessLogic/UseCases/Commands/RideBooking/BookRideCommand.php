<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideBooking;

use Ramsey\Uuid\UuidInterface;

class BookRideCommand
{

        public function __construct(public UuidInterface $riderId,
                                    public string $departure,
                                    public string $arrival,
                                    public bool   $wantsUberX)
        {
        }
}