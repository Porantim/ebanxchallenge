<?php

namespace EbanxChallenge\Core\Web\Response {

    use \EbanxChallenge\Core\Exception\ExceptionBase;
    use \EbanxChallenge\Core\Web\Context;

    class ExceptionResponse extends ResponseBase
    {
        public function __construct(ExceptionBase $content)
        {
            Context::$log->error($content->getMessage() . ' => ' . $content->getFile() . ' (line ' . $content->getLine() . ')');
            parent::__construct($content->getCode(), 'application/json; charset=utf-8', $content->getMessage());
        }
    }
}
