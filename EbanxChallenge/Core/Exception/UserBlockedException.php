<?php

namespace EbanxChallenge\Core\Exception
{
    class UserBlockedException extends ExceptionBase
    {
        public function __construct()
        {
            parent::__construct(
                "Forbidden: User blocked",
                403
            );
        }
    }
}
