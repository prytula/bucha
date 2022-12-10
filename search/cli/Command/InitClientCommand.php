<?php

namespace Cli\Command;

use Search\Service\Google\GoogleClientProvider;

class InitClientCommand implements CommandInterface
{
    private const NAME = 'init_client';

    public function execute(): int
    {
        try {
            GoogleClientProvider::getClient();
            echo "Ok!\n";
            return CommandInterface::SUCCESS;
        } catch (\Throwable $t) {
            echo self::NAME . ' Error: ' . $t->getMessage() . "\n";
            return CommandInterface::FAIL;
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }
}