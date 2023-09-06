<?php

use App\Tests\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories\RideRepositoryStub;
use App\Tests\Unit\UberTop\RideBookingContext\Adapters\Secondary\TripScanning\TripScannerStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\DeterministicDateProvider;
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
    $dateProvider = new DeterministicDateProvider();
    $dateProvider->setDateNow(new \DateTime('2022-03-04'));
    $bookRide = new BookRide($rideRepository, $tripScanner, $dateProvider);
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
    $wantsUberX, $arrival, $distance, $expectedPrice
) {
    // ARRANGE
    $rideRepository = new RideRepositoryStub();
    $tripScanner = new TripScannerStub();
    $dateProvider = new DeterministicDateProvider();
    $bookRide = new BookRide($rideRepository, $tripScanner, $dateProvider);
    $dateProvider->setDateNow(new \DateTime('2022-03-04'));
    $tripScanner->setDistance($distance);
    // ACT
    $bookRide->book("8 avenue Foch Paris", $arrival, $wantsUberX);
    // ASSERT
    expectBookedRides($rideRepository, $arrival, $expectedPrice);
})->with([
    "wants UberX for 0km" => [true, "8 avenue Foch Paris", 0, 15],
    "wants UberX for 1km" => [true, "199 avenue Foch Paris", 1, 15.5],
]);

it('should double the price because Christmas', function(
    $wantsUberX, $distance, $expectedPrice
) {
    // ARRANGE
    $rideRepository = new RideRepositoryStub();
    $tripScanner = new TripScannerStub();
    $tripScanner->setDistance($distance);
    $dateProvider = new DeterministicDateProvider();
    $dateProvider->setDateNow(new DateTime('2023-12-25'));
    $bookRide = new BookRide($rideRepository, $tripScanner, $dateProvider);
    // ACT
    $bookRide->book("8 avenue Foch Paris", "8 avenue Foch Paris", $wantsUberX);
    // ASSERT
    expectBookedRides($rideRepository, "8 avenue Foch Paris", $expectedPrice);
})->with([
    "no distance ride on Christmas" => [false, 0, 20],
    "with distance ride on Christmas" => [false, 1, 21],
    "with distance ride and UberX on Christmas" => [true, 1, 31],
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
