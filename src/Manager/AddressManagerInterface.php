<?php

declare(strict_types=1);

namespace App\Manager;

interface AddressManagerInterface
{
    public function recognizeAddress(string $filePath): string;
}
