<?php

use App\UberTop\RideBookingContext\BusinessLogic\Models\DateProvider;
use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\TripScanning\TripScanner;
use Ramsey\Uuid\Rfc4122\UuidV4;

beforeEach(function () {
    $this->container->get(DateProvider::class)->setDateNow(new \DateTime('2021-01-01 00:00:00'));
    $this->container->get(TripScanner::class)->setDistance(3);
});

it('should book a ride from Paris to Outside', function () {
    $this->client->request(
        'POST',
        '/rides',
        [
            'riderId' => '05ae7bef-646c-429f-bde8-c2d77bf778b8',
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