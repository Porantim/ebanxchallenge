<?php

namespace EbanxChallenge\Core\Web\Response {

    use EbanxChallenge\Core\Web\Context;

    class OptionsResponse extends ResponseBase
    {
        private string $allowedMethods;
        public function __construct(string $allowedMethods)
        {
           parent::__construct(200, '', '');
           $this->allowedMethods = $allowedMethods;
        }

        public function render(): void
        {
            if (ob_get_length() || ob_get_contents()) {
                @ob_clean();
            }
            
            http_response_code(200);

            $this->sendVersionHeader();
            $this->sendCorsHeaders();
            $this->sendAuthHeader();
            
            header("Access-Control-Allow-Methods: {$this->allowedMethods}");

            if (ob_get_length() || ob_get_contents()) {
                while (@ob_end_flush());
            }
        }
    }
}
