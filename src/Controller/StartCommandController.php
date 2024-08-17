<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\TelegramUserManagerInterface;
use Luzrain\TelegramBotApi\Method\SendMessage;
use Luzrain\TelegramBotApi\Type\KeyboardButton;
use Luzrain\TelegramBotApi\Type\KeyboardButtonArrayBuilder;
use Luzrain\TelegramBotApi\Type\Message;
use Luzrain\TelegramBotApi\Type\ReplyKeyboardMarkup;
use Luzrain\TelegramBotBundle\Attribute\OnCommand;
use Luzrain\TelegramBotBundle\TelegramCommand;

class StartCommandController extends TelegramCommand
{
    public function __construct(
        private readonly TelegramUserManagerInterface $manager
    ) {
    }

    #[OnCommand('/start', priority: 0)]
    public function __invoke(Message $message): SendMessage
    {
        $this->manager->process($message->from);

        $replyKeyboard = new ReplyKeyboardMarkup(
            oneTimeKeyboard: true,
            resizeKeyboard: true,
            keyboard: KeyboardButtonArrayBuilder::create()
                ->addButton(new KeyboardButton(text: 'send your location', requestLocation: true))
                ->addBreak(),
        );

        return new SendMessage(
            chatId: $message->chat->id,
            text: sprintf('Hi %s', $message->from->firstName),
            replyMarkup: $replyKeyboard,
        );
    }
}
