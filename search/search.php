<?php

require_once __DIR__ . '/vendor/autoload.php';

use Search\Core\Error\AppError;
use Search\Service\Search\Exception\SearchException;
use Search\Service\Search\SearchService;

header('Content-Type: application/json; charset=utf-8', response_code: 200);

try {
    $searchService = new SearchService();
} catch (\Throwable $t) {
    http_response_code($t->getCode() ?? 500);
    echo json_encode(AppError::makeInternalError('Google Client Error'));
    die();
}

$query = $_GET['query'] ?? null;

if (empty($query)) {
    http_response_code(400);
    echo json_encode(AppError::makeBadRequestError('Search Query cant be empty'));
    die();
}

$query = str_replace('_', ' ', $query);

try {
    echo json_encode($searchService->search($query));
} catch (SearchException $e) {
    http_response_code(500);
    echo json_encode(AppError::makeInternalError($e->getMessage()));
    die();
}

