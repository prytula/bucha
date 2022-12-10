<?php

namespace Cli\Command;

class CommandStorage
{
    /**
     * @var CommandInterface[]
     */
    private array $commands;

    public function __construct()
    {
        $this->commands = [];
        $this->commands[] = new InitClientCommand();
    }

    public function getCommand(string $name): ?CommandInterface
    {
        foreach ($this->commands as $command) {
            if ($command->getName() === $name) {
                return $command;
            }
        }
        return null;
    }
}