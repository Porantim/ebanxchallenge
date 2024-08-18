<?php

namespace EbanxChallenge\Core\Web\Response {

    use \EbanxChallenge\Core\Exception\ExceptionBase;
    use \EbanxChallenge\Core\Web\Context;

    class ErrorResponse extends ResponseBase
    {
        public function __construct(\Throwable $content)
        {
            Context::$log->error($content->getMessage() . ' => ' . $content->getFile() . ' (line ' . $content->getLine() . ')');
            parent::__construct(500, 'application/json; charset=utf-8', "An error occurred while processing the request. Please try again later.");
        }

    }
}
