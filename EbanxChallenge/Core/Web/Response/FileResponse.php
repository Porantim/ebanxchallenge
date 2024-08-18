<?php

namespace EbanxChallenge\Core\Web\Response {

    use EbanxChallenge\Core\Exception\FrontEndNotFoundException;
    use EbanxChallenge\Core\Web\Context;
    use EbanxChallenge\Core\Web\Mime;

    class FileResponse extends ResponseBase
    {
        public function __construct(string $fileName, string $mime = null)
        {
            $filePath = Context::$application->mapAbsolutePath($fileName);

            if($filePath === false)
            {
                throw new FrontEndNotFoundException();
            }

            if($mime === null)
            {
                $mime = Mime::getFromPath($filePath);
            }

            parent::__construct(200, $mime, $filePath);
        }

        public function render() : void
        {
            if (ob_get_length() || ob_get_contents()) {
                @ob_clean();
            }
            http_response_code($this->status);
            header('Content-Type: ' . $this->contentType);
            $this->sendVersionHeader();

            include ($this->content);

            if (ob_get_length() || ob_get_contents()) {
                while (@ob_end_flush());
            }
        }
    }
}
