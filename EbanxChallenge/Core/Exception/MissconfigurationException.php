<?php

namespace EbanxChallenge\Core\Exception
{
    class MissconfigurationException extends ExceptionBase
    {
        public function __construct(string $missconfiguration)
        {
            parent::__construct(
                "Missconfiguration exception",
                500
            );
        }
    }
}
