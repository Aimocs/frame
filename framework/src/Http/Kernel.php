<?php

namespace followed\framed\Http;
// use followed\framed\Http\Response;
use followed\framed\Dbal\Event\PostPersist;
use followed\framed\EventDispatcher\EventDispatcher;
use followed\framed\Http\Event\ResponseEvent;
use followed\framed\Routing\Router;
use followed\framed\Routing\RouterInterface;
use Psr\Container\ContainerInterface;
use followed\framed\Http\Middleware\RequestHandler;
class Kernel
{   
    private string $appEnv ;
    public function __construct(
        private ContainerInterface $container,
        private RequestHandler $requestHandler,
        private EventDispatcher $eventDispatcher
    ){
        $this->appEnv= $container->get('APP_ENV') ?? 'prod';
    }

    public function handle(Request $request): Response
    {
        try{

            $response= $this->requestHandler->handle($request);
            // [$routeHandler,$var]=$this->router->dispatch($request,$this->container);
            // $response=call_user_func_array($routeHandler,$var);
        }catch(HttpException $exception){
            $response=new Response($exception->getMessage(),$exception->getStatus());
        } catch (\Exception $excepition){
            $response=$this->createExceptionResponse($excepition);
        }
        $this->eventDispatcher->dispatch(new ResponseEvent($request,$response));
        return $response;
    }
    private function createExceptionResponse(\Exception $exception): Response
    {
        if(in_array($this->appEnv,['dev','test'])){
            throw $exception;
        }
        if($exception instanceof HTTPException){
            return new Response($exception->getMessage(),$exception->getStatus());
        }
        return new Response("Something went wrong",Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function terminate(Request $request, Response $response): void
    {
        if(!session_status()== PHP_SESSION_NONE){
        $request->getSession()?->clearFlash();
        }
    }
}