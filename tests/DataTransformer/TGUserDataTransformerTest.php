<?php

declare(strict_types=1);

namespace DataTransformer;

use App\DataTransformer\TGUserDataTransformer;
use App\Entity\TelegramUser;
use Luzrain\TelegramBotApi\Type\User;

class TGUserDataTransformerTest extends \PHPUnit\Framework\TestCase
{
    private TGUserDataTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new TGUserDataTransformer();
    }

    public function testTransformWithNewEntity(): void
    {
        $source = User::fromArray(
            [
                'id' => 12345,
                'is_bot' => false,
                'username' => 'testuser',
                'first_name' => 'test',
            ]
        );

        $result = $this->transformer->transform($source);

        $this->assertInstanceOf(TelegramUser::class, $result);
        $this->assertSame('testuser', $result->getUsername());
        $this->assertSame(12345, $result->getTelegramId());
    }

    public function testTransformWithExistingEntity(): void
    {
        $source = User::fromArray(
            [
                'id' => 54321,
                'is_bot' => false,
                'username' => 'existinguser',
                'first_name' => 'test',
            ]
        );

        $entity = new TelegramUser();
        $entity->setUsername('oldusername')->setTelegramId(11111);

        $result = $this->transformer->transform($source, $entity);

        $this->assertSame($entity, $result);
        $this->assertSame('existinguser', $result->getUsername());
        $this->assertSame(54321, $result->getTelegramId());
    }
}
