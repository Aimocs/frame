<?php 
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH.'/.env');

$container  = new \League\Container\Container();

$container->delegate(new \League\Container\ReflectionContainer(true));

$router =  include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'] ?? 'prod';

$templatesPath = BASE_PATH . '/templates';
$container->add('APP_ENV', new \League\Container\Argument\Literal\StringArgument($appEnv));

$databaseurl= 'pdo-sqlite:///' . BASE_PATH . '/var/db.sqlite';

$container->add(
    'base-commands-namespace',
    new \League\Container\Argument\Literal\StringArgument('followed\\framed\\Console\\Command\\'));
$container->add(followed\framed\Dbal\ConnectionFactory::class)
    ->addArguments([new \League\Container\Argument\Literal\StringArgument($databaseurl),\Doctrine\DBAL\Tools\DsnParser::class]);

$container->addShared(\Doctrine\DBAL\Connection::class, function () use ($container): \Doctrine\DBAL\Connection {
    return $container->get(followed\framed\Dbal\ConnectionFactory::class)->create();
});

$container->add(followed\framed\Routing\RouterInterface::class,followed\framed\Routing\Router::class);
$container->extend(followed\framed\Routing\RouterInterface::class)
    ->addMethodCall('setRoutes',[new \League\Container\Argument\Literal\ArrayArgument($router)]);
$container->add(followed\framed\Http\Middleware\RequestHandlerInterface::class,followed\framed\Http\Middleware\RequestHandler::class)
    ->addArgument($container);

$container->add(followed\framed\Http\Kernel::class)
    ->addArguments([followed\framed\Routing\RouterInterface::class,$container,followed\framed\Http\Middleware\RequestHandlerInterface::class]);

$container->addShared(
        followed\framed\Session\SessionInterface::class,
        followed\framed\Session\Session::class
    );
    
    $container->add('template-renderer-factory', followed\framed\Template\TwigFactory::class)
        ->addArguments([
            followed\framed\Session\SessionInterface::class,
            new \League\Container\Argument\Literal\StringArgument($templatesPath)
        ]);
    
    $container->addShared('twig', function () use ($container) {
        return $container->get('template-renderer-factory')->create();
    });
$container->add(followed\framed\Controller\AbstractController::class);

$container->inflector(followed\framed\Controller\AbstractController::class)       ->invokeMethod("setContainer",[$container]);

$container->add(followed\framed\Console\Application::class)
    ->addArgument($container);

$container->add(followed\framed\Console\Kernel::class)
    ->addArguments([$container,followed\framed\Console\Application::class]);

$container->add('database:migrations:migrate',followed\framed\Console\Command\MigrateDatabase::class)
    ->addArguments([\Doctrine\DBAL\Connection::class,new \League\Container\Argument\Literal\StringArgument(BASE_PATH . '/migrations')]);
$container->add( followed\framed\Http\Middleware\RouterDispatch::class)
    ->addArguments([followed\framed\Routing\RouterInterface::class,$container]);
$container->add(followed\framed\Authentication\SessionAuthentication::class)
    ->addArguments([
        \App\Repo\UserRepo::class,
        \followed\framed\Session\SessionInterface::class
    ]);
return $container;
