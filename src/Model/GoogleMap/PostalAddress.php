<?php

declare(strict_types=1);

namespace App\Model\GoogleMap;

class PostalAddress
{
    private string $address;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }
}
