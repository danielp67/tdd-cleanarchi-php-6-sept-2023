<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CancelRideCommandHandler
{
    public function __construct(private readonly RideRepository $rideRepository)
    {
    }

    public function __invoke(CancelRideCommand $command): void
    {
        $ride = $this->rideRepository->byId($command->rideId);

        $ride->cancel();
        $this->rideRepository->save($ride);
    }
}