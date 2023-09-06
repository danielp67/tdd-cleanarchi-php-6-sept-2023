<?php

use App\Tests\Unit\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking\RideRepositoryStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking\BookRide;

it('can book the most basic ride with no distance', function() {
    // ARRANGE
    $rideRepository = new RideRepositoryStub();
    $bookRide = new BookRide($rideRepository);
    // ACT
    $bookRide->book();
    // ASSERT
    expect($rideRepository->rides())->toEqual([
        new Ride(
            "123abc",
            "234def",
            "8 avenue Foch Paris",
            "8 avenue Foch Paris",
            10
        )
    ]);
});
