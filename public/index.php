<?php 
declare(strict_types=1);
require_once dirname(__DIR__) .'/vendor/autoload.php';
define('BASE_PATH',dirname(__DIR__));

use followed\framed\Http\Kernel;
use followed\framed\Http\Request;
use followed\framed\Http\Response;
use followed\framed\Routing\Router;
// request received 
$request = Request::createFromGlobals();

// router
$router = new Router();

// send response (string of content)
$kernel = new Kernel($router);
$response=$kernel->handle($request);
$response->send();
