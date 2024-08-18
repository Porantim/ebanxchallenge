<?php

namespace EbanxChallenge\Core {
    /**
     * Log
     */
    class Log
    {
        private readonly string $filePath;
        private readonly bool $verbose;

        /**
         * __construct
         *
         * @return void
         */
        public function __construct()
        {
            $basePath = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'EbanxChallenge');
            $dirPath = $basePath . DIRECTORY_SEPARATOR . 'Log';
            $this->filePath = $dirPath . DIRECTORY_SEPARATOR . date('Ymd') . '.log';
            $config = new Configuration();
            $this->verbose = $config->debug;
            $config = null;
        }

        /**
         * error
         *
         * @param  mixed $message
         * @return void
         */
        public function error(string $message): void
        {
            $this->write($message, 'ERROR');
        }

        /**
         * info
         *
         * @param  mixed $message
         * @return void
         */
        public function info(string $message): void
        {
            if ($this->verbose) {
                $this->write($message, 'INFO');
            }
        }

        /**
         * warning
         *
         * @param  string $message
         * @return void
         */
        public function warning(string $message): void
        {
            $this->write($message, 'WARNING');
        }

        /**
         * separator
         *
         * @return void
         */
        public function separator(): void
        {
            file_put_contents($this->filePath, '==============================================================' . PHP_EOL, FILE_APPEND);
        }

        /**
         * write
         *
         * @param  string $message
         * @param  string $mode
         * @return void
         */
        private function write(string $message, string $mode): void
        {
            $time = date('Y-m-d G:i:s');
            $line = "{$time} [$mode] $message" . PHP_EOL;
            file_put_contents($this->filePath, $line, FILE_APPEND);
        }
    }
}
