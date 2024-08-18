<?php

namespace EbanxChallenge\Core\Exception
{
    class UnauthorizedException extends ExceptionBase
    {
        public function __construct(string $message = 'Unauthorized')
        {
            parent::__construct($message, 401);
        }
    }
}
