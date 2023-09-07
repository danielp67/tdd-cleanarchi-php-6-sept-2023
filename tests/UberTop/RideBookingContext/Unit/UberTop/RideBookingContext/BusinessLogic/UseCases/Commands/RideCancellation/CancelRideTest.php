<?php

declare(strict_types=1);

use App\Tests\UberTop\RideBookingContext\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories\RideRepositoryStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Exception\CannotCancelFinishedRide;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\Models\RideStatus;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation\CancelRideCommand;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation\CancelRideCommandHandler;
use Ramsey\Uuid\Rfc4122\UuidV4;


beforeEach(function () {
    $this->rideRepository = new RideRepositoryStub();
    $this->handler = new CancelRideCommandHandler($this->rideRepository);

});

it ('cancels a ride', function () {
    // Arrange
    $rideId = UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42');

    $this->rideRepository->save(new Ride(
        $rideId,
        UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42'),
        '8 avenue du Général de Gaulle Lyon',
        '10 rue de Courcelles Paris',
        10,
        RideStatus::WAITING_FOR_DRIVER,
    ));

    // Act
    $this->handler->__invoke(new CancelRideCommand($rideId));

    // Assert
    expect($this->rideRepository->rides())->toEqual(
        [
            new Ride(
                $rideId,
                UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42'),
                '8 avenue du Général de Gaulle Lyon',
                '10 rue de Courcelles Paris',
                10,
                RideStatus::CANCELLED,
            ),
        ],
    );
});


it('cannot cancel a ride when not waiting for driver anymore', function () {
    // Arrange
    $rideId = UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42');

    $this->rideRepository->save(new Ride(
        $rideId,
        UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42'),
        '8 avenue du Général de Gaulle Lyon',
        '10 rue de Courcelles Paris',
        10,
        RideStatus::FINISHED,
    ));

    // Act
    $this->handler->__invoke(new CancelRideCommand($rideId));

})->throws(CannotCancelFinishedRide::class);