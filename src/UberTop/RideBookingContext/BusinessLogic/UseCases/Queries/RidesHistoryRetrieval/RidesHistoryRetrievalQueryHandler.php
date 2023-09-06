<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Queries\RideQuery;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval\ViewModel\RidesHistoryViewModel;

class RidesHistoryRetrievalQueryHandler
{

    private RideQuery $rideQueryGateway;

    public function __construct(RideQuery $rideQueryGateway)
    {
        $this->rideQueryGateway = $rideQueryGateway;
    }

    public function handle(): RidesHistoryViewModel
    {
        return $this->rideQueryGateway->ridesHistory();
    }
}