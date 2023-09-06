<?php

use App\Tests\UberTop\RideBookingContext\Unit\UberTop\RideBookingContext\Adapters\Secondary\Repositories\RideRepositoryStub;
use App\Tests\UberTop\RideBookingContext\Unit\UberTop\RideBookingContext\Adapters\Secondary\TripScanning\TripScannerStub;
use App\UberTop\RideBookingContext\BusinessLogic\Models\DeterministicDateProvider;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideBooking\BookRideCommand;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideBooking\BookRideCommandHandler;
use Ramsey\Uuid\Rfc4122\UuidV4;

beforeEach(function () {
    $this->rideRepository = new RideRepositoryStub();
    $this->tripScanner = new TripScannerStub();
    $this->dateProvider = new DeterministicDateProvider();
    $this->bookRide = new BookRideCommandHandler($this->rideRepository, $this->tripScanner, $this->dateProvider);
    $this->dateProvider->setDateNow(new \DateTime('2022-03-04'));
    $this->riderId = UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42');
});

it('can book a basic ride with some distance', function (
    $arrival, $distance, $expectedPrice
) {
    // ARRANGE
    $this->tripScanner->setDistance($distance);
    // ACT
    $this->bookRide->__invoke(new BookRideCommand($this->riderId, "8 avenue Foch Paris", $arrival, false));
    // ASSERT
    expectBookedRides($this->rideRepository, $this->riderId, $arrival, $expectedPrice);
})->with([
    "distance of 0km" => ["8 avenue Foch Paris", 0, 10],
    "distance of 1km" => ["199 avenue Foch Paris", 1, 10.5],
    "distance of 2km" => ["10 rue de Courcelles Paris", 2, 11]
]);


it('can book a basic ride with adapted price for uberX option', function (
    $wantsUberX, $arrival, $distance, $expectedPrice
) {
    // ARRANGE
    $this->tripScanner->setDistance($distance);
    // ACT
    $this->bookRide->__invoke(new BookRideCommand($this->riderId, "8 avenue Foch Paris", $arrival, $wantsUberX));
    // ASSERT
    expectBookedRides($this->rideRepository, $this->riderId, $arrival, $expectedPrice);
})->with([
    "wants UberX for 0km" => [true, "8 avenue Foch Paris", 0, 15],
    "wants UberX for 1km" => [true, "199 avenue Foch Paris", 1, 15.5],
]);

it('should double the price because Christmas', function (
    $wantsUberX, $distance, $expectedPrice
) {
    // ARRANGE
    $this->dateProvider->setDateNow(new DateTime('2023-12-25'));
    $this->tripScanner->setDistance($distance);
    // ACT
    $this->bookRide->__invoke(new BookRideCommand($this->riderId, "8 avenue Foch Paris", "8 avenue Foch Paris", $wantsUberX));
    // ASSERT
    expectBookedRides($this->rideRepository, $this->riderId, "8 avenue Foch Paris", $expectedPrice);
})->with([
    "no distance ride on Christmas" => [false, 0, 20],
    "with distance ride on Christmas" => [false, 1, 21],
    "with distance ride and UberX on Christmas" => [true, 1, 31],
]);

function expectBookedRides(RideRepositoryStub $rideRepository, $riderId, $arrival, $expectedPrice): void
{
    expect($rideRepository->rides())->toEqual([
        new Ride(
            UuidV4::fromString("a56ee94f-799a-46eb-97b2-2e5dece46339"),
            $riderId,
            "8 avenue Foch Paris",
            $arrival,
            $expectedPrice
        )
    ]);
}
