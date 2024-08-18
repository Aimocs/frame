<?php

namespace followed\framed\Controller;

use Psr\Container\ContainerInterface;
use followed\framed\Http\Response;
use followed\framed\Http\Request;
abstract class AbstractController
{
    protected ?ContainerInterface $container = null;
    protected Request $request;
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
    public function render(string $template , array $paramemters=[], Response $response=null){
        $content = $this->container->get('twig')->render($template, $paramemters);
        $response ??= new Response();
        $response->setContent($content);
        return $response;
    }
}