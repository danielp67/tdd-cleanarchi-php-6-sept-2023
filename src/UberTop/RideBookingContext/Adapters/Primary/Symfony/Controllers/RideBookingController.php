<?php

namespace App\UberTop\RideBookingContext\Adapters\Primary\Symfony\Controllers;

use App\UberTop\RideBookingContext\BusinessLogic\UseCases\RideBooking\BookRide;
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
    public function bookRide(Request $request): JsonResponse {
        $this->bookRide->book("8 avenue Foch Paris",
        "199 avenue Foch Paris");
        return $this->json('Ride booked', 201);
    }

}