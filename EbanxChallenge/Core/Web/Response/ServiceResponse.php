<?php

namespace EbanxChallenge\Core\Web\Response {

    class ServiceResponse extends ResponseBase
    {
        public function __construct(object | array | string | int | float | bool | null $content = null, int $status = 200)
        {
            parent::__construct($status, 'application/json; charset=utf-8', $content);
        }
    }

}
