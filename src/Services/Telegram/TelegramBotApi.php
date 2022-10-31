<?php

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\Exceptions\TelegramApiException;

/**
 * Отправка логов в телеграм
 */
final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $request = Http::get(self::HOST.$token. '/sendMessage' , [
                'chat_id' => $chatId,
                'text' => $text
            ])->throw()->json();

            return $request['ok'];
        } catch (\Throwable $e) {

            report(new TelegramApiException($e->getMessage()));

            return false;
        }
    }
}
