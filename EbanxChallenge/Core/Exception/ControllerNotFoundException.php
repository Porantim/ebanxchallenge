<?php

namespace EbanxChallenge\Core\Exception
{
    class ControllerNotFoundException extends ExceptionBase
    {
        public function __construct(string $controllerName)
        {
            parent::__construct(
                "Controller [{$controllerName}] not found",
                404
            );
        }
    }
}
