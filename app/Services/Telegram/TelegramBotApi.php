<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;

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
            ]);

            $body = $request->body();

            $body = json_decode($body, true);

            if(json_last_error() !== JSON_ERROR_NONE) {
                throw new TelegramApiException(__('Invalid json data from request'));
            }

            if(empty($body['ok'])) {
                throw new TelegramApiException(__('Error request data'));
            }

            return $body['ok'];
        } catch (TelegramApiException $e) {
            return false;
        }
    }
}
