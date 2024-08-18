<?php

namespace EbanxChallenge\Core\Exception
{
    class ObjectNotFoundException extends ExceptionBase
    {
        public function __construct(string $objectType, string $objectId)
        {
            parent::__construct(
                "Object [{$objectType}] ({$objectId}) not found",
                404
            );
        }
    }
}
