<?php

namespace followed\framed\Routing;
// use followed\framed\Routing\RouterInterface;
use function FastRoute\simpleDispatcher;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use followed\framed\Http\HttpException;
use followed\framed\Http\HttpExceptionMethodException;
use followed\framed\Http\Request;
class Router implements RouterInterface{
 
    public function dispatch(Request $request): array{

        $routeInfo=$this->routeInfoExtract($request);
        [$handler, $var] = $routeInfo;
        if(is_array($handler)){
            [$controller, $method] = $handler;
            $handler = [new $controller, $method];
        }
        
        return [$handler, $var];
    }

    private function routeInfoExtract(Request $request): array {
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {

            $routes = include BASE_PATH . '/routes/web.php';
            foreach ($routes as $route) {
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