<?php

declare(strict_types=1);

namespace App\Builder\GoogleMaps;

use App\Model\GoogleMap\PostalAddress;

class PostalAddressBuilder
{
    public static function build(string $address): PostalAddress
    {
        return (new PostalAddress())->setAddress($address);
    }
}
