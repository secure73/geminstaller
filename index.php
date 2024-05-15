<?php
require_once 'vendor/autoload.php';

use GemLibrary\Http\ApacheRequest;
use App\Core\Bootstrap;
use GemLibrary\Helper\NoCors;
use Symfony\Component\Dotenv\Dotenv;

NoCors::NoCors();

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/app/.env');

$webserver = new ApacheRequest();
$bootstrap = new Bootstrap($webserver->request);
