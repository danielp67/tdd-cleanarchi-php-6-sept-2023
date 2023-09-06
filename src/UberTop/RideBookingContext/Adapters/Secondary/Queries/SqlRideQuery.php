<?php

namespace App\UberTop\RideBookingContext\Adapters\Secondary\Queries;

use App\UberTop\RideBookingContext\BusinessLogic\SecondaryPorts\Queries\RideQuery;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval\ViewModel\RidesHistoryViewModel;
use App\UberTop\RideBookingContext\BusinessLogic\UseCases\Queries\RidesHistoryRetrieval\ViewModel\RidesInHistoryViewModel;
use Doctrine\ORM\EntityManagerInterface;

class SqlRideQuery implements RideQuery
{


    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function ridesHistory(): RidesHistoryViewModel
    {
        $conn = $this->entityManager->getConnection();
        $sql = "SELECT * from rides";
        try {
            $stmt = $conn->prepare($sql);
            $results = $stmt->executeQuery()->fetchAllAssociative();
            $ridesInHistoryViewModels = array_map(function ($result) {
                return new RidesInHistoryViewModel(
                    $result["id"],
                    $result["rider_id"],
                    $result["departure"],
                    $result["arrival"],
                    $result["price"],
                );
            }, $results);
            return new RidesHistoryViewModel(
                $ridesInHistoryViewModels,
                count($results),
            );
        } catch (\Exception $e) {
            dd($e);
        }
    }
}