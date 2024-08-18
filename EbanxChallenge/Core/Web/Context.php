<?php

namespace EbanxChallenge\Core\Web {

    use EbanxChallenge\Core\Log;

    class Context
    {
        public static ?Application $application = null;
        public static ?Request $request = null;
        public static ?Log $log = null;
    }
}
