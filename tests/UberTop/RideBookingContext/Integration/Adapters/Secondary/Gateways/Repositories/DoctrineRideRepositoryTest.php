<?php

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;
use Ramsey\Uuid\Rfc4122\UuidV4;

it('can save a ride', function () {
    $rideRepository = $this->bootedKernel->getContainer()->get(RideRepository::class);
    $ride = new Ride(
        UuidV4::fromString("71efde49-0a02-4ede-9cd2-c8f773fd6baf"),
        UuidV4::fromString("99efde49-0a02-4ede-9cd2-c8f773fd6bad"),
        '8 avenue Foch Paris',
        '9 avenue Foch Paris',
        10,
    );
    $rideRepository->save($ride);
    $savedRides = selectAllRides($this->entityManager);
    expect($savedRides)->toEqual([$ride]);
});