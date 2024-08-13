<?php 
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH.'/.env');

$container  = new \League\Container\Container();

$container->delegate(new \League\Container\ReflectionContainer(true));

$router =  include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'] ?? 'prod';

$templatesPath = BASE_PATH . '/templates';
$container->add('APP_ENV', new \League\Container\Argument\Literal\StringArgument($appEnv));

$container->add(followed\framed\Routing\RouterInterface::class,followed\framed\Routing\Router::class);
$container->extend(followed\framed\Routing\RouterInterface::class)
    ->addMethodCall('setRoutes',[new \League\Container\Argument\Literal\ArrayArgument($router)]);
$container->add(followed\framed\Http\Kernel::class)
    ->addArgument(followed\framed\Routing\RouterInterface::class)
    ->addArgument($container);
$container->addShared("filesystem-loader", \Twig\Loader\FilesystemLoader::class)
    ->addArgument(new \League\Container\Argument\Literal\StringArgument($templatesPath));

$container->addShared("twig",\Twig\Environment::class)
    ->addArgument("filesystem-loader");

$container->add(followed\framed\Controller\AbstractController::class);

$container->inflector(followed\framed\Controller\AbstractController::class)
    ->invokeMethod("setContainer",[$container]);
return $container;