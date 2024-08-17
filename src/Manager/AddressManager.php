<?php

declare(strict_types=1);

namespace App\Manager;

use App\Builder\LocationBuilder;
use App\Entity\Location;
use App\Repository\TelegramUserRepository;
use App\Service\GeminiServiceInterface;
use App\Service\TesseractOCRServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;

class AddressManager implements AddressManagerInterface
{
    private const QUERY = 'get comma-separated addresses from string ';

    public function __construct(
        private TesseractOCRServiceInterface $tesseractService,
        private GeminiServiceInterface $geminiService,
        private TelegramUserRepository $userRepository,
        private ManagerInterface $manager,
        private LocationBuilder $locationBuilder
    ) {
    }

    public function recognizeAddress(string $filePath, int $userId): string
    {
        $text = $this->tesseractService->recognizeTextFromImage($filePath);
        $addresses = $this->geminiService->ask(sprintf('%s %s', self::QUERY, $text));
        $this->processAddresses($addresses, $userId);

        return $addresses;
    }

    private function processAddresses(string $addresses, int $userId): array
    {
        $user = $this->userRepository->findOneBy(['telegramId' => $userId]);

        $addressesArray = explode(PHP_EOL, $addresses);
        $addressesArray = array_map(
            fn (string $address): Location => $this->locationBuilder->build($user, $address),
            $addressesArray
        );
        $this->manager->createMultiply(new ArrayCollection($addressesArray));

        return $addressesArray;
    }
}
