<?php

declare(strict_types=1);

namespace App\Tests\Builder\GoogleMaps;

use App\Builder\GoogleMaps\PostalAddressBuilder;
use App\Model\GoogleMap\PostalAddress;
use PHPUnit\Framework\TestCase;
use TypeError;

class PostalAddressBuilderTest extends  TestCase
{
    public function testBuildWithValidAddress(): void
    {
        $address = '123 Main St, Springfield, USA';
        $postalAddress = PostalAddressBuilder::build($address);

        $this->assertInstanceOf(PostalAddress::class, $postalAddress);
        $this->assertEquals($address, $postalAddress->getAddress());
    }

    public function testBuildWithEmptyAddress(): void
    {
        $address = '';
        $postalAddress = PostalAddressBuilder::build($address);

        $this->assertInstanceOf(PostalAddress::class, $postalAddress);
        $this->assertEquals($address, $postalAddress->getAddress());
    }

    public function testBuildWithWhitespaceAddress(): void
    {
        $address = '   ';
        $postalAddress = PostalAddressBuilder::build($address);

        $this->assertInstanceOf(PostalAddress::class, $postalAddress);
        $this->assertEquals($address, $postalAddress->getAddress());
    }

    public function testBuildWithNullAddress(): void
    {
        $this->expectException(TypeError::class);

        PostalAddressBuilder::build(null);
    }

    public function testBuildWithNumericAddress(): void
    {
        $this->expectException(TypeError::class);

        PostalAddressBuilder::build(12345);
    }

    public function testBuildWithArrayAddress(): void
    {
        $this->expectException(TypeError::class);

        PostalAddressBuilder::build(['123 Main St']);
    }
}