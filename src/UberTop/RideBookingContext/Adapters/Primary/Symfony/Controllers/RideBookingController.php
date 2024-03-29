<?php

namespace App\UberTop\RideBookingContext\Adapters\Primary\Symfony\Controllers;

use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideBooking\BookRideCommand;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideBooking\BookRideCommandHandler;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideCancellation\CancelRideCommand;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval\RidesHistoryRetrievalQueryHandler;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rides')]
class RideBookingController extends AbstractController
{


    public function __construct(private readonly MessageBusInterface               $messageBus,
                                private readonly RidesHistoryRetrievalQueryHandler $ridesHistoryRetrievalQueryHandler
    )
    {
    }

    #[Route('', name: 'book_ride', methods: ['POST'])]
    public function bookRide(Request $request): JsonResponse
    {
        $departure = $request->get('departure');
        $arrival = $request->get('arrival');
        $wantsUberX = $request->get('wantsUberX');
        $this->messageBus->dispatch(new BookRideCommand(UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42'),
            $departure,
            $arrival,
            $wantsUberX));
        return $this->json('Ride booked', 201);
    }

    #[Route('', name: 'rides_history', methods: ['GET'])]
    public function ridesHistory(): JsonResponse
    {
        $bookingsHistory = $this->ridesHistoryRetrievalQueryHandler->__invoke();
        return $this->json($bookingsHistory);
    }

    #[Route('/{rideId}', name: 'cancel_ride', methods: ['DELETE'])]
    public function cancelRide(Request $request): JsonResponse
    {
        $this->messageBus->dispatch(new CancelRideCommand(UuidV4::fromString($request->get('rideId')),
            UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42')));
        return $this->json('Ride cancelled', 200);
    }

}