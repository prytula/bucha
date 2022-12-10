<?php

namespace Search\Service\Google;

use Google\Exception;
use Google_Client;
use Google_Service_Sheets;
use Search\Service\Google\Exception\GoogleClientException;

class GoogleClientProvider
{
    public static function getClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        try {
            $client->setAuthConfig(GOOGLE_CONFIG_DIR . '/credentials.json');
        } catch (Exception $e) {
            throw GoogleClientException::fromThrowable($e);
        }
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $tokenPath = GOOGLE_CONFIG_DIR . '/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                if (PHP_SAPI !== 'cli') {
                    throw new GoogleClientException('ONLY CLI');
                }
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                if (array_key_exists('error', $accessToken)) {
                    throw new GoogleClientException(join(', ', $accessToken));
                }
            }
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }

            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
}