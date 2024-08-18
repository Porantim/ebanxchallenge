<?php

namespace EbanxChallenge\Core\Exception
{
    class FrontEndNotFoundException extends ExceptionBase
    {
        public function __construct()
        {
            $fileName = trim($_SERVER['REQUEST_URI'], '\\/ \t');
            parent::__construct(
                "Frontend file not found: {$fileName}",
                404
            );
        }
    }
}
