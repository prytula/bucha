<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Cli\Command\CommandInterface;
use Cli\Command\CommandStorage;

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    echo 'Only CLI';
    die();
}

$command = (new CommandStorage())->getCommand($argv[1]);
if (is_null($command)) {
    echo "Command not found!\n";
    exit(-1);
}

$code = $command->execute();
exit($code);
