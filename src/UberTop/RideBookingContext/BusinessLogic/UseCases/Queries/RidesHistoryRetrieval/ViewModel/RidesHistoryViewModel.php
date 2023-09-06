<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval\ViewModel;

class RidesHistoryViewModel
{


    public function __construct(public array $bookingInHistoryViewModel,
                                public int   $totalBookings)
    {
    }
}