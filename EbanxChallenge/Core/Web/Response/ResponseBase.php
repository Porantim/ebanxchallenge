<?php

namespace EbanxChallenge\Core\Web\Response {

    use EbanxChallenge\Core\Web\Context;
    use EbanxChallenge\Core\Web\Request;

    abstract class ResponseBase
    {
        protected int $status;
        protected string $contentType;
        protected object | array | string | int | float | bool | null $content;

        protected function __construct(int $status, string $contentType, object | array | string | int | float | bool | null $content)
        {
            $this->status = $status;
            $this->contentType = $contentType;
            $this->content = $content;
        }

        protected function sendCorsHeaders()
        {
            if(Context::$request === null) {
                Context::$request = new Request();
            }
            $originsAllowed = Context::$application->configuration->originsAllowed;
            if (count($originsAllowed) > 0) {
                $origin = isset(Context::$request->headers['Origin']) ? Context::$request->headers['Origin'] : false;
                if ($origin) {
                    header("Access-Control-Allow-Origin: {$origin}");
                }
            }
            $methodsAllowed = Context::$request->controller->methodsAllowed;

            header("Access-Control-Allow-Headers: Origin, App-Key, InputData, Authorization, Content-Type, Renew");
            header('Access-Control-Allow-Credentials: false');
            header('Access-Control-Max-Age: 3600');
            header("Access-Control-Allow-Methods: {$methodsAllowed}");
            
        }

        public function sendVersionHeader()
        {
            $versionParts = explode('.', Context::$application->configuration->version);
            $shortName = Context::$application->configuration->appShortName;
            header("X-Powered-By: {$shortName}/{$versionParts[0]}.{$versionParts[1]}");
            header("Server: {$shortName}");
        }

        protected function sendAuthHeader()
        {
            if(isset(Context::$request) && isset(Context::$request->currentAuthorization))
            {
                $currAuth = Context::$request->currentAuthorization;

                if($currAuth && $currAuth->isValid() && !$currAuth->isExpired())
                {
                    $newToken = $currAuth->renew();
                    header('Renew', $newToken);
                }
            }
        }

        public function render(): void
        {
            if (ob_get_length() || ob_get_contents()) {
                @ob_clean();
            }

            http_response_code($this->status);
            header('Content-Type: ' . $this->contentType);

            $this->sendVersionHeader();
            $this->sendCorsHeaders();
            $this->sendAuthHeader();

            if($this->content === null) {
                if($this->status === 200) {
                    echo 'OK';
                }
            }
            else {
                $objToResponse = $this->content;
                echo json_encode($objToResponse);
            }

            if (ob_get_length() || ob_get_contents()) {
                while (@ob_end_flush());
            }
        }
    }
}
