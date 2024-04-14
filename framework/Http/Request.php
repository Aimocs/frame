<?php

namespace followed\framed\Http;

class Request {

    public function __construct(
        public readonly array $getParams,
        public readonly array $postParams,
        public readonly array $cookies,
        public readonly array $files,
        public readonly array $server
    ){

    }
    public function getMethod():string
    {
        return $this->server['REQUEST_METHOD'];
    }
    public function getPath():string
    {
        return strtok($this->server["REQUEST_URI"],"?");
    }
    public static function createFromGlobals():static
    {
        return new static($_GET,$_POST,$_COOKIE,$_FILES,$_SERVER)   ;
    }
}