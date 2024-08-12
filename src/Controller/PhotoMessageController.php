<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\ImageManagerInterface;
use Luzrain\TelegramBotApi\Event\Message;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotApi\Type;
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
        $text = $this->manager->process($message);
        $inlineKeyboard =
            new Type\ReplyKeyboardMarkup(
                keyboard: Type\KeyboardButtonArrayBuilder::create()->addButton(
                    new Type\KeyboardButton(text: 'Calculate')
                )
            );

        return new SendMessage(
            chatId: $message->chat->id,
            text: $text,
            replyMarkup: $inlineKeyboard
        );
    }
}
