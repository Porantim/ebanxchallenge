<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once('../vendor/autoload.php');

\EbanxChallenge\Core\Web\Application::start();
