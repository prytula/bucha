<?php

namespace Cli\Command;

interface CommandInterface
{
    public const SUCCESS = 0;
    public const FAIL = -1;

    public function getName(): string;

    public function execute(): int;
}