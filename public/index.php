<?php 
declare(strict_types=1);
require_once dirname(__DIR__) .'/vendor/autoload.php';
define('BASE_PATH',dirname(__DIR__));

$container = require_once BASE_PATH . '/config/services.php';

$eventDispatcher=$container->get(\followed\framed\EventDispatcher\EventDispatcher::class);
$eventDispatcher->addListener(
   \followed\framed\Http\Event\ResponseEvent::class,
    new \App\EventListener\InternalErrorListener()
)->addListener(
\followed\framed\Http\Event\ResponseEvent::class,
    new \App\EventListener\ContentLengthListener()
)->addListener(
    \followed\framed\Dbal\Event\PostPersist::class,
    new \App\EventListener\SendEmail()
);

use followed\framed\Http\Kernel;
use followed\framed\Http\Request;
use followed\framed\Http\Response;
use followed\framed\Routing\Router;
// request received 
$request = Request::createFromGlobals();

$kernel = $container->get(Kernel::class);
$response=$kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);

