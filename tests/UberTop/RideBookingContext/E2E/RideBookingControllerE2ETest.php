<?php

use App\UberTop\RideBookingContext\BusinessLogic\Models\DateProvider;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\UuidGeneration\UuidGenerator;
use Ramsey\Uuid\Rfc4122\UuidV4;

beforeEach(function () {
    $this->container->get(DateProvider::class)->setDateNow(new \DateTime('2021-12-01 00:00:00'));
    $this->container->get(TripScanner::class)->setDistances(3, 25);
    $this->container->get(UuidGenerator::class)
        ->setNextUuids(UuidV4::fromString('a56ee94f-799a-46eb-97b2-2e5dece46339'),
            UuidV4::fromString('d9b61e19-4e47-48db-a45a-dde8481b5a42'));
});

it('should book a ride with uberX and some distance', function () {
    $this->client->request(
        'POST',
        '/rides',
        [
            'departure' => '10 rue de Courcelles Paris',
            'arrival' => '8 avenue du Général de Gaulle Lyon',
            'wantsUberX' => true
        ]
    );
    $this->client->request(
        'POST',
        '/rides',
        [
            'departure' => '10 rue de Courcelles Paris',
            'arrival' => '8 avenue du Général de Gaulle Lyon',
            'wantsUberX' => true
        ]
    );
    $this->assertResponseStatusCodeSame(201);
    assertJsonContent($this, 'Ride booked');
    $bookedRides = selectAllRides($this->entityManager);
    expect($bookedRides)->toEqual([
        new Ride(
            UuidV4::fromString('a56ee94f-799a-46eb-97b2-2e5dece46339'),
            UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42'),
            '10 rue de Courcelles Paris',
            '8 avenue du Général de Gaulle Lyon',
            16.5,
        ),
        new Ride(
            UuidV4::fromString('d9b61e19-4e47-48db-a45a-dde8481b5a42'),
            UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42'),
            '10 rue de Courcelles Paris',
            '8 avenue du Général de Gaulle Lyon',
            27.5,
        )
    ]);
});

function assertJsonContent($self, string $message): void
{
    $response = $self->client->getResponse();
    $content = $response->getContent();

    $self->assertJson($content);

    $self->assertStringContainsString($message, $content);
}