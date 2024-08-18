<?php

namespace followed\framed\Routing;
// use followed\framed\Routing\RouterInterface;
use function FastRoute\simpleDispatcher;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use followed\framed\Http\HttpException;
use followed\framed\Http\HttpExceptionMethodException;
use followed\framed\Http\Request;
use Psr\Container\ContainerInterface;
use followed\framed\Controller\AbstractController;
class Router implements RouterInterface{
    private array $routes = [];
    public function dispatch(Request $request, ContainerInterface $container): array{

        $routeInfo=$this->routeInfoExtract($request);
        [$handler, $var] = $routeInfo;
        if(is_array($handler)){
            [$controllerId, $method] = $handler;
            $controller= $container->get($controllerId);
            if (is_subclass_of($controller, AbstractController::class)) {
                $controller->setRequest($request);
            }
            $handler = [ $controller, $method];
        }



        return [$handler, $var];
    }
    public function setRoutes(array $routes):void {
        $this->routes = $routes;
    }

    private function routeInfoExtract(Request $request): array {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            foreach ($this->routes as $route) {
                $routeCollector->addRoute(...$route);
            }

        });

        // Dispatch a URI, to obtain the route info
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
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
    }
}