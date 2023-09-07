<?php

use App\Tests\UberTop\RideBookingContext\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories\RideRepositoryStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\Models\RideStatus;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation\CancelRideCommand;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation\CancelRideCommandHandler;
use Ramsey\Uuid\Rfc4122\UuidV4;

beforeEach(function() {
    $this->rideRepository = new RideRepositoryStub();
    $this->cancelRideCommandHandler = new CancelRideCommandHandler($this->rideRepository);
});

it('can cancel my ride because still in waiting for driver', function() {
    // ARRANGE
    $rideId = UuidV4::fromString('b56ee94f-799a-46eb-97b2-2e5dece46339');
    $this->rideRepository->feedWith(new Ride(
        $rideId,
        UuidV4::fromString('05ae7bef-646c-429f-bde8-c2d77bf778b8'),
        '8 avenue du Général de Gaulle Lyon',
        '10 rue de Courcelles Paris',
        15,
        RideStatus::WAITING_FOR_DRIVER
    ));
    // ACT
    $this->cancelRideCommandHandler->__invoke(
        new CancelRideCommand($rideId));
    // ASSERT
    expect($this->rideRepository->rides())->toEqual([
        new Ride(
            $rideId,
            UuidV4::fromString('05ae7bef-646c-429f-bde8-c2d77bf778b8'),
            '8 avenue du Général de Gaulle Lyon',
            '10 rue de Courcelles Paris',
            15,
            RideStatus::CANCELLED
        )
    ]);
});