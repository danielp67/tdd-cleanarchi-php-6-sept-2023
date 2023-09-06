<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\Repositories\Doctrine;

use App\UberTop\RideBookingContext\Adapters\Secondary\Repositories\Doctrine\Entities\RideEntity;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\UuidV4;

class DoctrineRideRepository implements RideRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Ride $ride): void
    {
        $rideEntity = new RideEntity(
            UuidV4::fromString($ride->getId()),
            UuidV4::fromString($ride->getRiderId()),
            $ride->getDeparture(),
            $ride->getArrival(),
            $ride->getPrice()
        );
        $this->entityManager->persist($rideEntity);
        $this->entityManager->flush();
    }
}