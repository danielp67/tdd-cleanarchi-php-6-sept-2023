<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

use Cassandra\Date;
use DateTime;

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
                                bool   $wantsUberX,
                                DateTime $dateNow): Ride
    {
        return new Ride($id,
            $riderId,
            $departure,
            $arrival,
            self::determinePrice($distance, $wantsUberX, $dateNow));
    }

    private static function determinePrice(float $distance, bool $wantsUberX, DateTime $dateNow): float
    {
        $price = 10 + $distance * 0.5;
        if ($wantsUberX)
            $price += 5;
        if($dateNow->format('m-d') === '12-25')
            $price *= 2;
        return $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRiderId(): string
    {
        return $this->riderId;
    }

    public function getDeparture(): string
    {
        return $this->departure;
    }

    public function getArrival(): string
    {
        return $this->arrival;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}