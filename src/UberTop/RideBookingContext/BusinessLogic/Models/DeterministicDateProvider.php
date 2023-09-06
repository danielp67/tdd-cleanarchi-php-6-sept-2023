<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

class DeterministicDateProvider implements DateProvider
{

    private \DateTime $dateNow;

    public function __construct()
    {
        $this->dateNow = new \DateTime("1970-01-03");
    }


    function now(): \DateTime
    {
        return $this->dateNow;
    }

    public function setDateNow(\DateTime $dateNow): void
    {
        $this->dateNow = $dateNow;
    }

    /**
     * @throws \Exception
     */
    public function setDateNowAsString(string $dateNowAsString): void
    {
        $this->dateNow = new \DateTime($dateNowAsString);
    }

}