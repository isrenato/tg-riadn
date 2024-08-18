<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\ImageManagerInterface;
use Luzrain\TelegramBotApi\Event\Message;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotApi\Type;
use Luzrain\TelegramBotApi\Type\KeyboardButton;
use Luzrain\TelegramBotApi\Type\KeyboardButtonArrayBuilder;
use Luzrain\TelegramBotApi\Type\ReplyKeyboardMarkup;
use Luzrain\TelegramBotBundle\Attribute\OnEvent;
use Luzrain\TelegramBotBundle\TelegramCommand;

class PhotoMessageController extends TelegramCommand
{
    public function __construct(
        private readonly ImageManagerInterface $manager
    ) {
    }

    #[OnEvent(event: Message::class, priority: 9)]
    public function __invoke(Type\Message $message): ?SendMessage
    {
        if (null === $message->photo) {
            return null;
        }

        $text = $this->manager->process($message);

        if (null === $text) {
            return new SendMessage(
                chatId: $message->chat->id,
                text: 'Addresses couldn\'t been found. Please try again'
            );
        }

        $replyKeyboard = new ReplyKeyboardMarkup(
            oneTimeKeyboard: true,
            resizeKeyboard: true,
            keyboard: KeyboardButtonArrayBuilder::create()
                ->addButton(new KeyboardButton(text: 'send your location', requestLocation: true))
        );

        return new SendMessage(
            chatId: $message->chat->id,
            text: 'Your addresses have been added and now you can send us your location',
            replyMarkup: $replyKeyboard
        );
    }
}
