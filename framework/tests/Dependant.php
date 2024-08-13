<?php


namespace followed\framed\tests;

class Dependant
{

    public function __construct(private Dependency $dependency)
    {
    }

    public function getDependency(): Dependency
    {
        return $this->dependency;
    }

}
