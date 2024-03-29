<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

use DateTime;
use Ramsey\Uuid\UuidInterface;

class Ride
{

    public function __construct(private UuidInterface $id,
                                private UuidInterface $riderId,
                                private string $departure,
                                private string $arrival,
                                private float  $price,
                                private RideStatus $status = RideStatus::WAITING_FOR_DRIVER,
    )
    {
    }

    public static function book(UuidInterface $id,
                                UuidInterface $riderId,
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

    /**
     * @throws CannotCancelFinishedRide
     * @throws CannotCancelAnotherRiderRide
     */
    public function cancel(UuidInterface $riderId): void
    {
        if(!$this->riderId->equals($riderId))
            throw new CannotCancelAnotherRiderRide('cannot cancel a ride that is not yours');
        if ($this->status === RideStatus::FINISHED)
            throw new CannotCancelFinishedRide('blabla');
        $this->status = RideStatus::CANCELLED;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRiderId(): UuidInterface
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

    public function getStatus(): RideStatus
    {
        return $this->status;
    }

}