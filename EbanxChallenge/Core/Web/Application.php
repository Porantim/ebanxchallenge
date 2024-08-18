<?php

namespace EbanxChallenge\Core\Web {

    use \EbanxChallenge\Core\Configuration;
    use \EbanxChallenge\Core\Web\Context;
    use \EbanxChallenge\Core\Web\Response\ExceptionResponse;
    use \EbanxChallenge\Core\Web\Response\ErrorResponse;
    use \EbanxChallenge\Core\Log;
    use \EbanxChallenge\Core\Exception\ExceptionBase;
    
    /**
     * Application
     * 
     * @property-read $configuration
     */
    class Application
    {
        public readonly Configuration $configuration;
        public readonly string $rootPath;
        public string $dirSlash = DIRECTORY_SEPARATOR;
                
        /**
         * __construct
         *
         * @return void
         */
        public function __construct()
        {
            $this->rootPath = $this->dirSlash . trim($_SERVER['DOCUMENT_ROOT'], $this->dirSlash);
            $this->configuration = new Configuration();

            set_error_handler(
                function (int $errno, string $errstr, string $errfile = '', int $errline = 0, array $errcontext = null) {
                    Application::processError($errno, $errstr, $errfile, $errline, $errcontext);
                },
                E_ALL
            );
            register_shutdown_function(
                function () {
                    $error = error_get_last();
                    if ($error !== null) {
                        Application::processError($error['type'], $error['message'], $error['file'], $error['line']);
                    }
                }
            );
        }
        
        /**
         * Process the request.
         *
         * This method is responsible for processing the incoming request.
         * It should be called to handle the request and generate the appropriate response.
         *
         * @return void
         */
        public static function start() : void {
            
            try {
                Context::$log = new Log();
                Context::$application = new Application();
                Context::$request = new Request();
                $response = Context::$request->process();
                $response->render();
            } 
            catch (ExceptionBase $exb) {
                $response = new ExceptionResponse($exb);
                $response->render();
            }
            catch (\Throwable $thr) {
                $response = new ErrorResponse($thr);
                $response->render();
            }
            
        }

        public static function processError(int $errno, string $errstr, string $errfile = '', int $errline = 0, array $errcontext = null) : void {
            
            Context::$log->error("{$errstr} -- {$errfile} -- Line: {$errline}");
            $exception = new \Exception($errstr, $errno);
            $response = new ErrorResponse($exception);
            $response->render();

            die();
        }
        
        /**
         * Maps the given relative path to an absolute path.
         *
         * @param string $path The relative path to be mapped.
         * @return string|bool The absolute path if mapping is successful, otherwise false.
         */
        public function mapAbsolutePath(string $path) : string | bool
        {
            if(!$this->isAbsolutePath($path))
            {
                $path = str_replace(['/', '\\'], $this->dirSlash, "{$this->rootPath}{$this->dirSlash}..{$this->dirSlash}EbanxChallenge{$this->dirSlash}{$path}");
            }
            return realpath($path);
        }
        
        /**
         * isAbsolutePath
         *
         * @param  string $path
         * @return bool
         */
        private function isAbsolutePath(string $path) : bool
        {
            $pathParts = explode($this->dirSlash, str_replace(['/', '\\'], $this->dirSlash, $path), 4);
            $pathLen = count($pathParts);

            $rootParts = explode($this->dirSlash, str_replace(['/', '\\'], $this->dirSlash, $this->rootPath), 4);
            $rootLen = count($rootParts);

            $limit = $pathLen < $rootLen ? $pathLen : $rootLen - 1;
            
            $equal = true;

            for($i = 0; $i < $limit; $i++)
            {
                $equal = $equal && $pathParts[$i] == $rootParts[$i];
            }

            return $equal;
        }

    }
}
