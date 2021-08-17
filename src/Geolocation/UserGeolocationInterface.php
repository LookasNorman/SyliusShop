<?php

declare(strict_types=1);

namespace App\Geolocation;

interface UserGeolocationInterface
{
    public function getLocation(): string;
}
