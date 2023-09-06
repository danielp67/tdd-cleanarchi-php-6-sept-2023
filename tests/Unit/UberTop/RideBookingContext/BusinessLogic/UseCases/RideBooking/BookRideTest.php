<?php

use App\Tests\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories\RideRepositoryStub;
use App\Tests\Unit\UberTop\RideBookingContext\Adapters\Secondary\TripScanning\TripScannerStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking\BookRide;

/**
 * @param RideRepositoryStub $rideRepository
 * @param $arrival
 * @param $expectedPrice
 * @return void
 */

it('can book a basic ride with some distance', function(
    $arrival, $distance, $expectedPrice
) {
    // ARRANGE
    $rideRepository = new RideRepositoryStub();
    $tripScanner = new TripScannerStub();
    $bookRide = new BookRide($rideRepository, $tripScanner);
    $tripScanner->setDistance($distance);
    // ACT
    $bookRide->book("8 avenue Foch Paris", $arrival, false);
    // ASSERT
    expectBookedRides($rideRepository, $arrival, $expectedPrice);
})->with([
    "distance of 0km" => ["8 avenue Foch Paris", 0, 10],
    "distance of 1km" => ["199 avenue Foch Paris", 1, 10.5],
    "distance of 2km" => ["10 rue de Courcelles Paris", 2, 11]
]);


it('can book a basic ride with adapted price for uberX option', function(
    $hasUberX, $distance, $expectedPrice
) {
    // ARRANGE
    $rideRepository = new RideRepositoryStub();
    $tripScanner = new TripScannerStub();
    $bookRide = new BookRide($rideRepository, $tripScanner);
    $tripScanner->setDistance($distance);
    // ACT
    $bookRide->book("8 avenue Foch Paris", "8 avenue Foch Paris", $hasUberX);
    // ASSERT
    expectBookedRides($rideRepository, "8 avenue Foch Paris", $expectedPrice);
})->with([
    "has UberX for 0km" => [true, 0, 15],
    "has UberX for 1km" => [true, 1, 15.5],
]);

function expectBookedRides(RideRepositoryStub $rideRepository, $arrival, $expectedPrice): void
{
    expect($rideRepository->rides())->toEqual([
        new Ride(
            "123abc",
            "234def",
            "8 avenue Foch Paris",
            $arrival,
            $expectedPrice
        )
    ]);
}
