<?php
require_once 'vendor/autoload.php';

use GemLibrary\Helper\NoCors;
use GemFramework\Core\Bootstrap;
use GemLibrary\Http\ApacheRequest;

NoCors::NoCors();
$serverRequest = new ApacheRequest();
$bootstrap = new Bootstrap($serverRequest->request);


