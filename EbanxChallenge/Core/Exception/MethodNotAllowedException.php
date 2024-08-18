<?php

namespace EbanxChallenge\Core\Exception
{
    class MethodNotAllowedException extends ExceptionBase
    {
        public function __construct()
        {
            parent::__construct(
                "Method not allowed",
                405
            );
        }
    }
}
