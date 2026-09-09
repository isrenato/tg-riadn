<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Builder\LocationBuilder;
use App\Entity\Location;
use App\Entity\TelegramUser;
use App\Manager\AddressManager;
use App\Manager\ManagerInterface;
use App\Repository\TelegramUserRepository;
use App\Service\GeminiServiceInterface;
use App\Service\TesseractOCRServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use thiagoalessio\TesseractOCR\UnsuccessfulCommandException;

class AddressManagerTest extends TestCase
{
    private TesseractOCRServiceInterface $tesseractService;
    private GeminiServiceInterface $geminiService;
    private TelegramUserRepository $userRepository;
    private ManagerInterface $manager;
    private LocationBuilder $locationBuilder;
    private AddressManager $addressManager;

    protected function setUp(): void
    {
        $this->tesseractService = $this->createMock(TesseractOCRServiceInterface::class);
        $this->geminiService = $this->createMock(GeminiServiceInterface::class);
        $this->userRepository = $this->createMock(TelegramUserRepository::class);
        $this->manager = $this->createMock(ManagerInterface::class);
        $this->locationBuilder = $this->createMock(LocationBuilder::class);

        $this->addressManager = new AddressManager(
            $this->tesseractService,
            $this->geminiService,
            $this->userRepository,
            $this->manager,
            $this->locationBuilder
        );
    }

    public function testRecognizeAddressReturnsNullWhenOcrFails(): void
    {
        $this->tesseractService->method('recognizeTextFromImage')
            ->willThrowException(new UnsuccessfulCommandException());

        $this->geminiService->expects($this->never())->method('ask');
        $this->manager->expects($this->never())->method('createMultiply');

        $result = $this->addressManager->recognizeAddress('/tmp/photo.jpg', 12345);

        $this->assertNull($result);
    }

    public function testRecognizeAddressSplitsAddressesOnSemicolon(): void
    {
        $user = new TelegramUser();

        $this->tesseractService->method('recognizeTextFromImage')
            ->with('/tmp/photo.jpg')
            ->willReturn('raw ocr text');

        $this->geminiService->method('ask')
            ->with($this->stringContains('get semicolon-separated addresses from string'))
            ->willReturn('Address One;Address Two;Address Three');

        $this->userRepository->method('findOneBy')
            ->with(['telegramId' => 12345])
            ->willReturn($user);

        $builtLocations = [new Location(), new Location(), new Location()];
        $this->locationBuilder->method('build')
            ->willReturnOnConsecutiveCalls(...$builtLocations);

        $this->manager->expects($this->once())
            ->method('createMultiply')
            ->with($this->callback(
                function (ArrayCollection $collection) use ($builtLocations): bool {
                    return $collection->toArray() === $builtLocations;
                }
            ));

        $result = $this->addressManager->recognizeAddress('/tmp/photo.jpg', 12345);

        $this->assertSame('Address One;Address Two;Address Three', $result);
    }
}
