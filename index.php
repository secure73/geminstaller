<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use GemLibrary\Helper\NoCors;
use GemFramework\Core\Bootstrap;
use GemLibrary\Http\ApacheRequest;

NoCors::NoCors();
$serverRequest = new ApacheRequest();
$bootstrap = new Bootstrap($serverRequest->request);
