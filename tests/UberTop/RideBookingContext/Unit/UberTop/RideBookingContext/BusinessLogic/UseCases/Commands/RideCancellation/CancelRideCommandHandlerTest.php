<?php

use App\Tests\UberTop\RideBookingContext\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories\RideRepositoryStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\CannotCancelAnotherRiderRide;
use App\UberTop\RideBookingContext\BusinessLogic\Models\CannotCancelFinishedRide;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\Models\RideStatus;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation\CancelRideCommand;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation\CancelRideCommandHandler;
use Ramsey\Uuid\Rfc4122\UuidV4;

beforeEach(function () {
    $this->rideRepository = new RideRepositoryStub();
    $this->cancelRideCommandHandler = new CancelRideCommandHandler($this->rideRepository);
    $this->myRiderId = UuidV4::fromString('376ee94f-799a-46eb-97b2-2e5dece46339');
    $this->yourRiderId = UuidV4::fromString('886ee94f-799a-46eb-97b2-2e5dece46339');
});

it('can cancel my ride because still waiting for driver', function () {
    // ARRANGE
    $rideId = UuidV4::fromString('b56ee94f-799a-46eb-97b2-2e5dece46339');
    $this->rideRepository->feedWith(new Ride(
        $rideId,
        $this->myRiderId,
        '8 avenue du Général de Gaulle Lyon',
        '10 rue de Courcelles Paris',
        15,
        RideStatus::WAITING_FOR_DRIVER
    ));
    // ACT
    $this->cancelRideCommandHandler->__invoke(
        new CancelRideCommand($rideId, $this->myRiderId));
    // ASSERT
    expect($this->rideRepository->rides())->toEqual([
        new Ride(
            $rideId,
            $this->myRiderId,
            '8 avenue du Général de Gaulle Lyon',
            '10 rue de Courcelles Paris',
            15,
            RideStatus::CANCELLED
        )
    ]);
});

it('cannot cancel a ride when not waiting for driver anymore', function () {
    $this->rideRepository->save(new Ride(
        $rideId = UuidV4::fromString('b56ee94f-799a-46eb-97b2-2e5dece46339'),
        $this->myRiderId,
        '8 avenue du Général de Gaulle Lyon',
        '10 rue de Courcelles Paris',
        10,
        RideStatus::FINISHED,
    ));
    $this->cancelRideCommandHandler->__invoke(new CancelRideCommand($rideId, $this->myRiderId));
})->throws(CannotCancelFinishedRide::class);

it('cannot cancel YOUR ride even still waiting for driver', function () {
    $rideId = UuidV4::fromString('b56ee94f-799a-46eb-97b2-2e5dece46339');
    $this->rideRepository->feedWith(new Ride(
        $rideId,
        $this->yourRiderId,
        '8 avenue du Général de Gaulle Lyon',
        '10 rue de Courcelles Paris',
        15,
        RideStatus::WAITING_FOR_DRIVER
    ));
    $this->cancelRideCommandHandler->__invoke(
        new CancelRideCommand($rideId,
            $this->myRiderId));
})->throws(CannotCancelAnotherRiderRide::class, 'cannot cancel a ride that is not yours');