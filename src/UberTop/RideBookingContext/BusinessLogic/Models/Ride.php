<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

class Ride
{

    public function __construct(private string $id,
                                private string $riderId,
                                private string $departure,
                                private string $arrival,
                                private float  $price)
    {
    }

    public static function book(string $id,
                                string $riderId,
                                string $departure,
                                string $arrival,
                                float  $distance,
                                bool   $wantsUberX): Ride
    {
        return new Ride($id,
            $riderId,
            $departure,
            $arrival,
            self::determinePrice($distance, $wantsUberX));
    }

    private static function determinePrice(float $distance, bool $wantsUberX): float
    {
        $price = 10 + $distance * 0.5;
        if ($wantsUberX)
            $price += 5;
        return $price;
    }
}