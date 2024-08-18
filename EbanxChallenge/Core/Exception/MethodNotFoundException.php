<?php

namespace EbanxChallenge\Core\Exception
{
    class MethodNotFoundException extends ExceptionBase
    {
        public function __construct()
        {
            $fileName = trim($_SERVER['REQUEST_URI'], '\\/ \t');
            parent::__construct(
                "Mehtod not found",
                404
            );
        }
    }
}
