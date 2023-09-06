<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval\ViewModel;

class RidesInHistoryViewModel
{
    public function __construct(public string    $id,
                                public string    $riderId,
                                public string    $departure,
                                public string    $arrival,
                                public float     $price)
    {
    }

}