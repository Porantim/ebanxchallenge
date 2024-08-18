<?php

namespace EbanxChallenge\Core {

    use EbanxChallenge\Core\Exception\PreconditionFailedException;

    class InputValidator
    {        
        /**
         * email
         *
         * @param  string $email
         * @return string
         */
        public static function email(string $email): string
        {
            $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

            if ($validEmail === false | null) {
                throw new PreconditionFailedException("Invalid e-mail");
            }

            return $validEmail;
        }
        
        /**
         * int
         *
         * @param  mixed $int
         * @return int
         */
        public static function int(mixed $int): int
        {
            $validInt = filter_var(intval($int), FILTER_VALIDATE_INT);

            if ($validInt === false | null) {
                throw new PreconditionFailedException("Invalid integer number");
            }

            return $validInt;
        }
        
        /**
         * float
         *
         * @param  mixed $float
         * @return float
         */
        public static function float(mixed $float): float
        {
            $validFloat = filter_var($float, FILTER_VALIDATE_FLOAT);

            if ($validFloat === false | null) {
                throw new PreconditionFailedException("Invalid float number");
            }

            return floatval($validFloat);
        }
        
        /**
         * string
         *
         * @param  string $text
         * @return string
         */
        public static function string(string $text): string
        {
            $validText = filter_var($text, FILTER_DEFAULT);

            if ($validText === false | null) {
                throw new PreconditionFailedException("Invalid string");
            }

            return $validText;
        }
    }
}
