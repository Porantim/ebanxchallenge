<?php

namespace EbanxChallenge\Core\Exception
{
    class PreconditionFailedException extends ExceptionBase
    {
        public function __construct(string $message)
        {
            parent::__construct(
                "Precondition Failed: {$message}",
                412
            );
        }
    }
}
