<?php

namespace StudentsGradesApi\Application\Command;

/**
 * @template CI of CommandInterface
 */
interface CommandHandlerInterface
{
    /**
     * @param CI $command
     */
    public function handle(CommandInterface $command): CommandResponseInterface;

    /**
     * @return class-string
     */
    public static function listenTo(): string;
}
