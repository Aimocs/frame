<?php

namespace followed\framed\Container;

use Psr\Container\ContainerInterface;
class Container implements ContainerInterface
{
  private array $services = [];
  public function add(string $id, string|object $concrete= null){
    if(is_null($concrete)){
      if(!class_exists($id)){
        throw new ContainerException("Class $id not found ");
      }
        $concrete = $id;
    }
    $this->services[$id] = $concrete; 
  }
   public function get(string $id){
    if (!$this->has($id)) {
      if (!class_exists($id)) {
          throw new ContainerExceptio2n("Service $id could not be resolved");
      }

      $this->add($id);
  }

  $object = $this->resolve($this->services[$id]);

  return $object;
   }

   private function resolve($class):object{

    $reflectionClass = new \ReflectionClass($class);
    
    $constructor = $reflectionClass->getConstructor();
    
    if( null == $constructor){
        return $reflectionClass->newInstance();
    }

    $constructorParams = $constructor->getParameters();
    
    $classDependencies = $this->resolveClassDependencies( $constructorParams);

    $service = $reflectionClass->newInstanceArgs($classDependencies);

    return $service;

   }

   private function resolveClassDependencies(array $constructorParams):array{

    $classDependencies = [];

    foreach($constructorParams as $param){

      $serviceType = $param->getType();

      $service = $this->get($serviceType->getName());

      $classDependencies[] = $service;
   }
   return $classDependencies;
  }
   public function has(string $id):bool{
     return array_key_exists($id, $this->services); 
   }
}
