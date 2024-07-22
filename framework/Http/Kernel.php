<?php

namespace followed\framed\Http;
// use followed\framed\Http\Response;
use followed\framed\Routing\Router;

class Kernel
{   
    public function __construct(
        private Router $router
    ){}

    public function handle(Request $request): Response
    {
        try{
            [$routeHandler,$var]=$this->router->dispatch($request);
            $response=call_user_func_array($routeHandler,$var);
        }catch(HTTPException $exception){
            $response=new Response($exception->getMessage(),$exception->getStatus());

        } catch (\Exception $excepition){
            $response=new Response($excepition->getMessage(),500);
        }

        return $response;
        
    }
}