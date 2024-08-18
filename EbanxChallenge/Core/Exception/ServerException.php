<?php

namespace EbanxChallenge\Core\Exception
{
    class ServerException extends ExceptionBase
    {
        public function __construct(string $message = 'Internal server error')
        {
            parent::__construct($message, 500);
        }
    }
}
