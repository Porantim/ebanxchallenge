<?php

namespace EbanxChallenge\Core
{    
    /**
     * @property-read string|array|int
     */
    class Configuration
    {
        /**
         * @var array
         */
        private array $configData;
        
        /**
         * __get
         *
         * @param  string $key
         * @return string
         */
        public function __get(string $key) : string | array | int
        {
            return $this->configData[$key];
        }
        
        /**
         * Constructor for the Configuration class.
         *
         * @param string|null $filePath The file path to be used.
         */
        public function __construct(string $filePath = null)
        {
            if($filePath === null)
            {
                $filePath = self::getDefaultPath();
            }
            $content = file_get_contents($filePath);
            $this->configData = json_decode($content, true);
        }

        /**
         * Returns the default path for the Configuration file.
         *
         * @return string The default path for the Configuration file.
         */
        private static function getDefaultPath() : string
        {
            $basePath = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'EbanxChallenge');
            $configPath = $basePath . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'config.json';

            return $configPath;
        }
        
        /**
         * reveal
         *
         * @param  string $ciphered Encrypted text
         * @return string
         */
        public function reveal(string $ciphered) : string
        {
            $data = explode(":", $ciphered);
            return openssl_decrypt(hex2bin($data[1]), 'aes-256-cbc', $this->configData['security']["configPhrase"], OPENSSL_RAW_DATA, hex2bin($data[0]));
        }
    }
}
