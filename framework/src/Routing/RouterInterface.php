<?php

namespace followed\framed\Routing;
use followed\framed\Http\Request;
use Psr\Container\ContainerInterface;
interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array;

}