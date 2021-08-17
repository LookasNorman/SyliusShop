<?php

declare(strict_types=1);

namespace App\Geolocation;

final class UserGeolocation implements UserGeolocationInterface
{

    public function getLocation(): string
    {
        return str_split($_SERVER['HTTP_ACCEPT_LANGUAGE'], 5)[0];
    }
}
