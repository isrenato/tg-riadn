<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Manager\AddressManagerInterface;
use App\Manager\ImageManager;
use App\Service\TelegramFileServiceInterface;
use App\Service\TelegramImageServiceInterface;
use Luzrain\TelegramBotApi\Type\File;
use Luzrain\TelegramBotApi\Type\Message;
use PHPUnit\Framework\TestCase;

class ImageManagerTest extends TestCase
{
    private TelegramImageServiceInterface $telegramImageService;
    private TelegramFileServiceInterface $fileService;
    private AddressManagerInterface $addressManager;
    private ImageManager $imageManager;

    protected function setUp(): void
    {
        $this->telegramImageService = $this->createMock(TelegramImageServiceInterface::class);
        $this->fileService = $this->createMock(TelegramFileServiceInterface::class);
        $this->addressManager = $this->createMock(AddressManagerInterface::class);

        $this->imageManager = new ImageManager(
            $this->telegramImageService,
            $this->fileService,
            $this->addressManager
        );
    }

    public function testProcessUsesThirdSmallestPhotoSize(): void
    {
        $message = $this->buildMessageWithPhotos(
            [
                ['file_id' => 'thumb', 'file_unique_id' => 'u0', 'width' => 90, 'height' => 90],
                ['file_id' => 'small', 'file_unique_id' => 'u1', 'width' => 320, 'height' => 320],
                ['file_id' => 'high-res', 'file_unique_id' => 'u2', 'width' => 1280, 'height' => 1280],
                ['file_id' => 'original', 'file_unique_id' => 'u3', 'width' => 2560, 'height' => 2560],
            ]
        );

        $file = File::fromArray(['file_id' => 'high-res', 'file_unique_id' => 'u2', 'file_path' => 'photos/high-res.jpg']);

        $this->telegramImageService->expects($this->once())
            ->method('getImageUrl')
            ->with('high-res')
            ->willReturn($file);

        $this->fileService->method('downloadFile')
            ->with('photos/high-res.jpg')
            ->willReturn('/tmp/downloaded.jpg');

        $this->addressManager->method('recognizeAddress')
            ->with('/tmp/downloaded.jpg', $message->from->id)
            ->willReturn('Some Address');

        $result = $this->imageManager->process($message);

        $this->assertSame('Some Address', $result);
    }

    public function testProcessReturnsNullWhenAddressManagerFindsNothing(): void
    {
        $message = $this->buildMessageWithPhotos(
            [
                ['file_id' => 'thumb', 'file_unique_id' => 'u0', 'width' => 90, 'height' => 90],
                ['file_id' => 'small', 'file_unique_id' => 'u1', 'width' => 320, 'height' => 320],
                ['file_id' => 'high-res', 'file_unique_id' => 'u2', 'width' => 1280, 'height' => 1280],
            ]
        );

        $file = File::fromArray(['file_id' => 'high-res', 'file_unique_id' => 'u2', 'file_path' => 'photos/high-res.jpg']);

        $this->telegramImageService->method('getImageUrl')->willReturn($file);
        $this->fileService->method('downloadFile')->willReturn('/tmp/downloaded.jpg');
        $this->addressManager->method('recognizeAddress')->willReturn(null);

        $result = $this->imageManager->process($message);

        $this->assertNull($result);
    }

    private function buildMessageWithPhotos(array $photos): Message
    {
        return Message::fromArray(
            [
                'message_id' => 1,
                'date' => 1700000000,
                'chat' => ['id' => 555, 'type' => 'private'],
                'from' => ['id' => 999, 'is_bot' => false, 'first_name' => 'Test'],
                'photo' => $photos,
            ]
        );
    }
}
