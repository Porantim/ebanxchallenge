<?php

namespace EbanxChallenge\Core\Web {

    use EbanxChallenge\Core\Exception\MethodNotAllowedException;
    use EbanxChallenge\Core\Exception\MethodNotFoundException;
    use EbanxChallenge\Core\Exception\InvalidRequestException;
    use EbanxChallenge\Core\Exception\UnauthorizedException;
    use EbanxChallenge\Core\Web\Response\OptionsResponse;
    use EbanxChallenge\Core\Web\Response\ResponseBase;

    abstract class ControllerBase
    {
        protected readonly Request $request;
        public $methodsAllowed = "GET, POST, HEAD, PUT, DELETE, OPTIONS, TRACE, PATCH";
        
        /**
         * __construct
         * 
         * Class constructor
         *
         * @param  Request $currentRequest
         * @return ControllerBase
         */
        public function __construct(Request &$currentRequest)
        {
            $this->request = $currentRequest;
        }

        public function init(): void
        {
            $this->validateAppKey();
            $this->validateToken();
        }

        /**
         * validateAppKey
         *
         * @return void
         * 
         */
        protected function validateAppKey(): void
        {
            return;
        }

        protected function validateToken(): void
        {
            return;
        }

        protected function executeSubMethod(int $parameterIndex)
        {
            $method =  Context::$request->method . '_' . Context::$request->parameters[$parameterIndex];

            if (method_exists($this, $method))
            {
                return $this->$method();
            } else
            {
                throw new MethodNotFoundException();
            }
        }

        public function get(): ResponseBase
        {
            throw new MethodNotAllowedException();
        }

        public function post(): ResponseBase
        {
            throw new MethodNotAllowedException();
        }

        public function head(): ResponseBase
        {
            throw new MethodNotAllowedException();
        }

        public function put(): ResponseBase
        {
            throw new MethodNotAllowedException();
        }

        public function delete(): ResponseBase
        {
            throw new MethodNotAllowedException();
        }

        public function options(): OptionsResponse
        {
            return new OptionsResponse($this->methodsAllowed);
        }

        public function trace(): ResponseBase
        {
            throw new MethodNotAllowedException();
        }

        public function patch(): ResponseBase
        {
            throw new MethodNotAllowedException();
        }
    }
}
