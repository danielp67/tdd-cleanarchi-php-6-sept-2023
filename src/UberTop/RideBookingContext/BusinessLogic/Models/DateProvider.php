<?php

namespace App\UberTop\RideBookingContext\BusinessLogic\Models;

interface DateProvider
{
    function now(): \DateTime;
}