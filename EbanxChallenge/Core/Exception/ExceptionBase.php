<?php

namespace EbanxChallenge\Core\Exception
{
    abstract class ExceptionBase extends \Exception
    {
        protected function __construct(string $message, int $code, \Throwable | null $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }
}
