<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\Repositories\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity]
#[ORM\Table(name: 'rides')]
class RideEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidV4 $id;

    #[ORM\Column(type: 'uuid')]
    private UuidV4 $riderId;

    #[ORM\Column(type: 'string')]
    private string $departure;

    #[ORM\Column(type: 'string')]
    private string $arrival;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(type: 'string')]
    private string $status;


    public function __construct(UuidV4 $id,
                                UuidV4 $riderId,
                                string $departure,
                                string $arrival,
                                float  $price,
                                string $status = 'WAITING_FOR_DRIVER')
    {
        $this->id = $id;
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->price = $price;
        $this->riderId = $riderId;
        $this->status = $status;
    }


    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getRiderId(): UuidV4
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setRiderId(UuidV4 $riderId): void
    {
        $this->riderId = $riderId;
    }

    public function setDeparture(string $departure): void
    {
        $this->departure = $departure;
    }

    public function setArrival(string $arrival): void
    {
        $this->arrival = $arrival;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }



}