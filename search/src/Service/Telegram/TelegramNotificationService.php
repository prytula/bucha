<?php

namespace Search\Service\Telegram;

class TelegramNotificationService
{
    private const BASE_URI = 'https://api.telegram.org';

    private string $telegramToken = BOT_TOKEN;
    private string $chatID = CHAT_ID;

    public function __construct(private bool $useCurl = true) {}

    public function notify(string $message): void
    {
        $url = self::BASE_URI . '/bot' . $this->telegramToken . '/sendMessage';
        $data = [
            'chat_id' => $this->chatID,
            'text' => $message,
            'disable_web_page_preview' => true,
        ];

        if (preg_match('/<[^<]+>/', $data['text'])) {
            $data['parse_mode'] = 'HTML';
        }

        if ($this->useCurl && extension_loaded('curl')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            curl_exec($ch);
        } else {
            $opts = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($data),
                    'timeout' => 10,
                ],
                'ssl' => [
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                ],
            ];

            @file_get_contents($url, false, stream_context_create($opts));
        }
    }
}