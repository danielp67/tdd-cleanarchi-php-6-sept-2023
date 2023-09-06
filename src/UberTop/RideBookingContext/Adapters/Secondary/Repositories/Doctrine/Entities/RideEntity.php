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

    public function __construct(UuidV4             $id,
                                UuidV4             $riderId,
                                string             $departure,
                                string             $arrival,
                                float              $price)
    {
        $this->id = $id;
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->price = $price;
        $this->riderId = $riderId;
    }


    public function getId(): UuidV4
    {
        return $this->id;
    }

}