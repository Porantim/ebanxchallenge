<?php

namespace EbanxChallenge\Core\Web {

    use EbanxChallenge\Core\Exception\ControllerNotFoundException;
    use EbanxChallenge\Core\Security\Token;
    use EbanxChallenge\Core\Web\Response\ResponseBase;

    class Request
    {
        public readonly string $method;
        public readonly string $controllerName;
        public readonly ControllerBase $controller;
        public readonly array $parameters;
        public readonly ?object $inputData;
        public readonly array $headers;

        public function __construct()
        {
            $config = Context::$application->configuration;

            $request_uri = explode('?', urldecode(trim($_SERVER['REQUEST_URI'], '// ')))[0];
            $uriParts = explode('/', $request_uri);

            if (count($uriParts) > 0 && empty(trim($uriParts[0]))) {
                array_shift($uriParts);
            }

            if (count($uriParts) > 0) {
                $this->controllerName = ucfirst(array_shift($uriParts));
            } else {
                $this->controllerName = 'Frontend';
            }
            
            Context::$log->info('Controller = ' . $this->controllerName);

            $this->parameters = $uriParts;

            $contents = file_get_contents('php://input');

            $this->headers = getallheaders();

            if ($contents !== null) {
                $this->inputData = json_decode($contents);
            } else if (array_key_exists('InputData', $this->headers)) {
                $this->inputData = json_decode($this->headers['InputData']);
            }

            $this->method = strtolower($_SERVER['REQUEST_METHOD']);

            Context::$log->info('method=' . $this->method);

            $controllerQualifiedName = 'EbanxChallenge\Controller\\' . $this->controllerName . 'Controller';

            if (!class_exists($controllerQualifiedName, true)) {
                throw new ControllerNotFoundException($this->controllerName);
            }

            $this->controller = new $controllerQualifiedName($this);
        }

        public function process(): ResponseBase
        {
            call_user_func(array($this->controller, "init"));
            return call_user_func(array($this->controller, $this->method));
        }
    }
}
