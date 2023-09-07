<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\Repositories\Doctrine;

use App\UberTop\RideBookingContext\Adapters\Secondary\Repositories\Doctrine\Entities\RideEntity;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\Models\RideStatus;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Uid\UuidV4 as UuidV4Alias;

class DoctrineRideRepository implements RideRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Ride $ride): void
    {
        $existingRideEntity = $this->entityManager->getRepository(RideEntity::class)
            ->find(UuidV4Alias::fromString($ride->getId()->toString()));
        if($existingRideEntity !== null) {
            $existingRideEntity->setDeparture($ride->getDeparture());
            $existingRideEntity->setArrival($ride->getArrival());
            $existingRideEntity->setPrice($ride->getPrice());
            $existingRideEntity->setStatus($ride->getStatus()->name);
            $this->entityManager->flush();
            return;
        }
        $rideEntity = new RideEntity(
            UuidV4Alias::fromString($ride->getId()->toString()),
            UuidV4Alias::fromString($ride->getRiderId()->toString()),
            $ride->getDeparture(),
            $ride->getArrival(),
            $ride->getPrice()
        );
        $this->entityManager->persist($rideEntity);
        $this->entityManager->flush();
    }

    public function byId(UuidInterface $rideId): Ride
    {
        $rideEntity = $this->entityManager->getRepository(RideEntity::class)
            ->find($rideId);
        return new Ride(
            UuidV4::fromString($rideEntity->getId()),
            UuidV4::fromString($rideEntity->getRiderId()),
            $rideEntity->getDeparture(),
            $rideEntity->getArrival(),
            $rideEntity->getPrice(),
            RideStatus::from($rideEntity->getStatus())
        );
    }
}