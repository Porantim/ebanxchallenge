<?php

namespace EbanxChallenge\Core\Exception
{
    class InvalidRequestException extends ExceptionBase
    {
        public function __construct(string $message)
        {
            parent::__construct(
                "Bad Request: {$message}",
                400
            );
        }
    }
}
