<?php

namespace App\UberTop\RideBookingContext\Adapters\Primary\Symfony\Controllers;

use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Commands\RideBooking\BookRide;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rides')]
class RideBookingController extends AbstractController
{


    public function __construct(private readonly BookRide $bookRide)
    {
    }

    #[Route('', name: 'book_ride', methods: ['POST'])]
    public function bookRide(Request $request): JsonResponse
    {
        $departure = $request->get('departure');
        $arrival = $request->get('arrival');
        $wantsUberX = $request->get('wantsUberX');
        $this->bookRide->book(
            UuidV4::fromString('b6b61e19-4e47-48db-a45a-dde8481b5a42'), $departure,
            $arrival,
            $wantsUberX);
        return $this->json('Ride booked', 201);
    }

}