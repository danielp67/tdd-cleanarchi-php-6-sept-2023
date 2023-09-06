<?php

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Repositories\RideRepository;

it('can save a ride', function () {
    $rideRepository = $this->bootedKernel->getContainer()->get(RideRepository::class);
    $ride = new Ride(
        "71efde49-0a02-4ede-9cd2-c8f773fd6baf",
        "99efde49-0a02-4ede-9cd2-c8f773fd6bad",
        '8 avenue Foch Paris',
        '9 avenue Foch Paris',
        10,
    );
    $rideRepository->save($ride);
    $savedRides = selectAllRides($this->entityManager);
    expect($savedRides)->toEqual([$ride]);
});