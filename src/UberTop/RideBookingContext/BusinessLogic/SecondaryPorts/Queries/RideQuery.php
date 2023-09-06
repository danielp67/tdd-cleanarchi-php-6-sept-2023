<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Queries;

use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval\ViewModel\RidesHistoryViewModel;

interface RideQuery
{
    public function ridesHistory(): RidesHistoryViewModel;
}