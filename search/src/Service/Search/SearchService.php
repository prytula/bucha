<?php

namespace Search\Service\Search;

use Google_Service_Sheets;
use Search\Service\Google\Exception\GoogleClientException;
use Search\Service\Google\GoogleClientProvider;
use Search\Service\Search\DTO\RusCriminal;
use Search\Service\Search\Exception\SearchException;
use Search\Service\Telegram\TelegramNotificationService;

class SearchService
{
    private Google_Service_Sheets $service;

    /**
     * @throws GoogleClientException
     */
    public function __construct()
    {
        $this->service = new Google_Service_Sheets(GoogleClientProvider::getClient());
    }

    /**
     * @return RusCriminal[]
     * @throws SearchException
     */
    public function search(string $query): array
    {
        try {
            $response = $this->service->spreadsheets_values->get(SPREADSHEET_ID, SEARCH_RANGE);
        } catch (\Throwable $t) {
            (new TelegramNotificationService())->notify('Google Client Request Error! (Check Token)');
            throw SearchException::createGoogleRequestError($t);
        }
        $values = $response->getValues();

        $result = [];
        foreach ($values as $value) {
            if (
                str_contains($value[NAME_KEY], $query)
                ||
                str_contains($value[UNIT_KEY], $query)
                ||
                str_contains($value[NUMBER_KEY], $query)
            ) {
                $result[] = $this->buildRusCriminal($value);
            }
        }
        return $result;
    }

    /**
     * @return RusCriminal[]
     */
    public function findAll(): array
    {
        $response = $this->service->spreadsheets_values->get(SPREADSHEET_ID, SEARCH_RANGE);
        $values = $response->getValues();

        $result = [];
        foreach ($values as $value) {
            $result[] = $this->buildRusCriminal($value);
        }
        return $result;
    }

    private function buildRusCriminal(array $value): RusCriminal
    {
        return new RusCriminal(
            $value[0] ?? '',
            $value[1] ?? '',
            $value[2] ?? '',
            $value[3] ?? '',
            $value[4] ?? '',
            $value[5] ?? '',
            $value[6] ?? '',
//            $value[7],
//            $value[8],
//            $value[9],
//            $value[10] ?? '',
//            $value[11] ?? '',
//            $value[12] ?? ''
        );
    }
}