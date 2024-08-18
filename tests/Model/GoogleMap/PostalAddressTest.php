<?php

declare(strict_types=1);

namespace App\Tests\Model\GoogleMap;

use App\Model\GoogleMap\PostalAddress;
use PHPUnit\Framework\TestCase;

class PostalAddressTest extends TestCase
{
    public function testSetAndGetAddress(): void
    {
        $address = '1600 Amphitheatre Parkway, Mountain View, CA';

        $postalAddress = new PostalAddress();
        $postalAddress->setAddress($address);

        $this->assertEquals($address, $postalAddress->getAddress());
    }

    public function testMethodChaining(): void
    {
        $address = 'One Apple Park Way, Cupertino, CA';

        $postalAddress = (new PostalAddress())->setAddress($address);

        $this->assertEquals($address, $postalAddress->getAddress());
    }
}
