<?php

namespace App\Services;

use Telegram\Bot\Api;

class TelegramHistory
{
    protected Api $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_HISTORY_BOT_TOKEN'));
    }

    public function send(string $message): void
    {
        $chatId = env('TELEGRAM_HISTORY_CHAT_ID');

        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $this->escapeMarkdown($message),
            'parse_mode' => 'MarkdownV2',
        ]);
    }

    private function escapeMarkdown(string $text): string
    {
        // Экранирование символов, поддерживаемых MarkdownV2
        $escapeChars = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        foreach ($escapeChars as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
        return $text;
    }
}
