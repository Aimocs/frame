<?php

namespace followed\framed\Http\Middleware;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use followed\framed\Http\HttpException;
use followed\framed\Http\HttpExceptionMethodException;
use followed\framed\Http\Request;
use followed\framed\Http\Response;
use function FastRoute\simpleDispatcher;

class ExtractRouteInfo implements MiddlewareInterface
{
    public function __construct(private array $routes)
    {

    }
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {

        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            foreach ($this->routes as $route) {
                $routeCollector->addRoute(...$route);
            }

        });

        // Dispatch a URI, to obtain the route info
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                // Set $request->routeHandler
                $request->setRouteHandler($routeInfo[1]);
                // Set $request->routeHandlerArgs
                $request->setRouteHandlerArgs($routeInfo[2]);
                // Inject route middleware on handler
                if (is_array($routeInfo[1]) && isset($routeInfo[1][2])) {
                    $requestHandler->injectMiddleware($routeInfo[1][2]);
                }
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(',',$routeInfo[1]);
                $e = new HttpExceptionMethodException("Bad Method - Method Allowed: $allowedMethods");
                $e->setStatus(405);
                throw $e;
            default:
                $e = new HttpException("Not Found");
                $e->setStatus(404);
                throw $e;
        }
       return $requestHandler->handle($request);
    }

}