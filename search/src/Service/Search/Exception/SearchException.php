<?php

namespace Search\Service\Search\Exception;

use Search\Core\Exception\AppException;

class SearchException extends AppException
{
    public static function createGoogleRequestError(\Throwable $t): static
    {
        return new static('Google request error!', 500, $t);
    }
}