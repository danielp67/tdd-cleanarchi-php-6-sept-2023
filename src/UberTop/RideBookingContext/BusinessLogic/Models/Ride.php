<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

class Ride
{

    public function __construct(private string $id,
                                private string $riderId,
                                private string $departure,
                                private string $arrival,
                                private float $price)
    {
    }
}