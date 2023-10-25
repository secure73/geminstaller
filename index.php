<?php
require_once('vendor/autoload.php');

use Gemvc\Http\ApacheRequest as HttpRequest;

$req = new HttpRequest();
$req = $req->request;

var_dump($req);


