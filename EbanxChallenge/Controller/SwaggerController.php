<?php

namespace EbanxChallenge\Controller {

    use EbanxChallenge\Core\Exception\FrontEndNotFoundException;
    use EbanxChallenge\Core\Web\Context;
    use EbanxChallenge\Core\Web\ControllerBase;
    use EbanxChallenge\Core\Web\Response\FileResponse;

    class SwaggerController extends ControllerBase
    {
        public $methodsAllowed = "GET";

        /**
         * Handles the GET request and retriveves the openapi.json file.
         *
         * @return FileResponse The file response for openapi.json.
         */
        public function get(): FileResponse
        {            
            $indexPath = Context::$application->mapAbsolutePath(Context::$application->configuration->frontedPath);

            if($indexPath === false)
            {
                throw new FrontEndNotFoundException();
            }

            $fileRelativePath = "openapi.json";

            $fileAbsolutePath = $indexPath . DIRECTORY_SEPARATOR . $fileRelativePath;

            if (!file_exists($fileAbsolutePath))
            {
                throw new FrontEndNotFoundException();
            }
            else
            {
                return new FileResponse($fileAbsolutePath);
            }
        }
    }
}
