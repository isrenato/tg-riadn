<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\DataTransformer\TGUserDataTransformerInterface;
use App\Entity\TelegramUser;
use App\Manager\ManagerInterface;
use App\Manager\TelegramUserManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Luzrain\TelegramBotApi\Type\User;
use PHPUnit\Framework\TestCase;

class TelegramUserManagerTest extends TestCase
{
    private TGUserDataTransformerInterface $transformer;
    private ServiceEntityRepository $repository;
    private ManagerInterface $manager;
    private TelegramUserManager $telegramUserManager;

    protected function setUp(): void
    {
        $this->transformer = $this->createMock(TGUserDataTransformerInterface::class);
        $this->repository = $this->createMock(ServiceEntityRepository::class);
        $this->manager = $this->createMock(ManagerInterface::class);

        $this->telegramUserManager = new TelegramUserManager(
            $this->transformer,
            $this->repository,
            $this->manager
        );
    }

    public function testProcessCreatesNewUser(): void
    {
        $user = User::fromArray(
            [
                'id' => 12345,
                'is_bot' => false,
                'username' => 'testuser',
                'first_name' => 'test',
            ]
        );

        $this->repository->method('findOneBy')
            ->with(['telegramId' => $user->id])
            ->willReturn(null);

        $telegramUser = new TelegramUser();
        $this->transformer->method('transform')
            ->with($user)
            ->willReturn($telegramUser);

        $this->manager->expects($this->once())
            ->method('create')
            ->with($telegramUser);

        $result = $this->telegramUserManager->process($user);

        $this->assertSame($telegramUser, $result);
    }

    public function testProcessUpdatesExistingUser(): void
    {
        $user = User::fromArray(
            [
                'id' => 12345,
                'is_bot' => false,
                'username' => 'testuser',
                'first_name' => 'test',
            ]
        );

        $telegramUser = new TelegramUser();

        $this->repository->method('findOneBy')
            ->with(['telegramId' => $user->id])
            ->willReturn($telegramUser);

        $this->transformer->method('transform')
            ->with($user, $telegramUser)
            ->willReturn($telegramUser);

        $this->manager->expects($this->once())
            ->method('update');

        $result = $this->telegramUserManager->process($user);

        $this->assertSame($telegramUser, $result);
    }
}
