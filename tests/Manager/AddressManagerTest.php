<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\GeminiServiceInterface;
use App\Service\TesseractOCRServiceInterface;
use PHPUnit\Framework\TestCase;

class AddressManagerTest extends TestCase
{
    private TesseractOCRServiceInterface $tesseractService;
    private GeminiServiceInterface $geminiService;
    private AddressManager $addressManager;

    protected function setUp(): void
    {
        $this->tesseractService = $this->createMock(TesseractOCRServiceInterface::class);
        $this->geminiService = $this->createMock(GeminiServiceInterface::class);
        $this->addressManager = new AddressManager($this->tesseractService, $this->geminiService);
    }

    public function testRecognizeAddressReturnsFormattedAddress()
    {
        $filePath = 'path/to/image.jpg';
        $recognizedText = '123 Main St, Anytown, USA';
        $expectedResponse = '123 Main St, Anytown, USA';

        $this->tesseractService
            ->method('recognizeTextFromImage')
            ->with($filePath)
            ->willReturn($recognizedText);

        $this->geminiService
            ->method('ask')
            ->with('get grupped comma-separated addresses from string '.$recognizedText)
            ->willReturn($expectedResponse);

        $result = $this->addressManager->recognizeAddress($filePath);
        $this->assertEquals($expectedResponse, $result);
    }

    public function testRecognizeAddressHandlesEmptyResponse()
    {
        $filePath = 'path/to/image.jpg';
        $recognizedText = '456 Elm St, Othertown, USA';
        $expectedResponse = '';

        $this->tesseractService
            ->method('recognizeTextFromImage')
            ->with($filePath)
            ->willReturn($recognizedText);

        $this->geminiService
            ->method('ask')
            ->with('get grupped comma-separated addresses from string '.$recognizedText)
            ->willReturn($expectedResponse);

        $result = $this->addressManager->recognizeAddress($filePath);
        $this->assertEquals($expectedResponse, $result);
    }

    public function testRecognizeAddressHandlesRecognitionFailure()
    {
        $filePath = 'path/to/image.jpg';
        $recognizedText = '';

        $this->tesseractService
            ->method('recognizeTextFromImage')
            ->with($filePath)
            ->willReturn($recognizedText);

        $this->geminiService
            ->method('ask')
            ->with('get grupped comma-separated addresses from string '.$recognizedText)
            ->willReturn('');

        $result = $this->addressManager->recognizeAddress($filePath);
        $this->assertEquals('', $result);
    }

    public function testRecognizeAddressHandlesExceptionFromTesseract()
    {
        $filePath = 'path/to/image.jpg';

        $this->tesseractService
            ->method('recognizeTextFromImage')
            ->with($filePath)
            ->willThrowException(new \Exception('OCR Error'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('OCR Error');
        $this->addressManager->recognizeAddress($filePath);
    }

    public function testRecognizeAddressHandlesExceptionFromGemini()
    {
        $filePath = 'path/to/image.jpg';
        $recognizedText = '789 Maple St, Sometown, USA';

        $this->tesseractService
            ->method('recognizeTextFromImage')
            ->with($filePath)
            ->willReturn($recognizedText);

        $this->geminiService
            ->method('ask')
            ->with('get grupped comma-separated addresses from string '.$recognizedText)
            ->willThrowException(new \Exception('Gemini Error'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Gemini Error');
        $this->addressManager->recognizeAddress($filePath);
    }
}
