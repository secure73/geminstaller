<?php
require_once 'vendor/autoload.php';

use GemLibrary\Helper\NoCors;
use GemFramework\Core\Bootstrap;
use GemLibrary\Http\GemRequest;

NoCors::NoCors();
$bootstrap = new Bootstrap(new GemRequest());
$bootstrap->response->show();


