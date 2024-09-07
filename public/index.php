<?php 
declare(strict_types=1);
require_once dirname(__DIR__) .'/vendor/autoload.php';
define('BASE_PATH',dirname(__DIR__));

$container = require_once BASE_PATH . '/config/services.php';

use followed\framed\Http\Kernel;
use followed\framed\Http\Request;
//bootstrapping
require  BASE_PATH . '/bootstrap/bootstrap.php';
// request received 
$request = Request::createFromGlobals();

$kernel = $container->get(Kernel::class);
$response=$kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);

