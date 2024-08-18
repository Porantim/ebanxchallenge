<?php

namespace EbanxChallenge\Controller {

    use EbanxChallenge\Core\Exception\FrontEndNotFoundException;
    use EbanxChallenge\Core\Web\Context;
    use EbanxChallenge\Core\Web\ControllerBase;
    use EbanxChallenge\Core\Web\Response\FileResponse;

    class SwaggerController extends ControllerBase
    {
        public $methodsAllowed = "GET";

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
                return new FileResponse($indexPath . DIRECTORY_SEPARATOR . Context::$application->configuration->frontendFile);
            }
            else
            {
                return new FileResponse($fileAbsolutePath);
            }
        }
    }
}
