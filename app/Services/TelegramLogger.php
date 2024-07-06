<?php

namespace App\Services;

use Telegram\Bot\Api;
use Throwable;

class TelegramLogger
{
    protected Api $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function logError(Throwable $exception): void
    {
        $chatId = env('TELEGRAM_CHAT_ID');
        $message = $this->formatErrorMessage($exception);

        $chunks = str_split($message, 4096);

        foreach ($chunks as $chunk) {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $chunk,
                'parse_mode' => 'MarkdownV2',
            ]);
        }
    }

    private function formatErrorMessage(Throwable $exception): string
    {
        $trace = $this->getShortenedTrace($exception->getTraceAsString());

        return "*Error:* `" . $this->escapeMarkdown($exception->getMessage()) . "`\n\n"
            . "*File:* `" . $this->escapeMarkdown($exception->getFile()) . "`\n"
            . "*Line:* `" . $this->escapeMarkdown($exception->getLine()) . "`\n\n"
            . "*Trace:*\n"
            . "```\n" // Начало блока кода с новой строки
            . $trace
            . "\n```";
    }

    private function getShortenedTrace(string $trace): string
    {
        $lines = explode("\n", $trace);
        $shortenedTrace = array_slice($lines, 0, 10); // Обрезаем до первых 10 строк
        return implode("\n", $shortenedTrace);
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
