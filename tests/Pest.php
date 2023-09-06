<?php

use App\UberTop\RideBookingContext\BusinessLogic\Models\Ride;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

uses()->beforeEach(function () {
})->group('unit')->in('UberTop/RideBookingContext/Unit');

uses(WebTestCase::class)->beforeEach(function () {
    $this->client = $this::createClient(["environment", "test"]);
    $this->container = $this->client->getContainer();
    $this->entityManager = $this->container->get('doctrine')->getManager();
    cleanDatabase($this->entityManager);
})->group('e2e')->in('UberTop/RideBookingContext/E2E');

uses(KernelTestCase::class)->beforeEach(function () {
    $this->bootedKernel = $this::bootKernel(["environment" => "test"]);
    $this->container = $this->bootedKernel->getContainer();
    $this->entityManager = $this->container->get('doctrine')->getManager();
    cleanDatabase($this->entityManager);
})->group('integration')->in('UberTop/RideBookingContext/Integration');
function cleanDatabase(EntityManagerInterface $entityManager): void
{
    $tables = ['rides'];
    $conn = $entityManager->getConnection();
    foreach ($tables as $table) {
        $sql = 'TRUNCATE TABLE '.$table.';';
        try {
            $stmt = $conn->prepare($sql);
            $stmt->executeStatement();
        } catch(\Exception $e) {
            dd($e);
        }
    }
}

function selectAllRides(EntityManagerInterface $entityManager): array
{

    $conn = $entityManager->getConnection();
    $sql = 'SELECT * FROM rides';
    try {
        $stmt = $conn->prepare($sql);
        $results = $stmt->executeQuery()->fetchAllAssociative();
        return array_map(function ($row) {
            return new Ride(
                $row['id'],
                $row['rider_id'],
                $row['departure'],
                $row['arrival'],
                $row['price'],
            );
        }, $results);
    } catch (\Exception $e) {
        dd($e);
    }
}
