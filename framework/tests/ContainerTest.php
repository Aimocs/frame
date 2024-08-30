<?php
namespace followed\framed\tests;
use PHPUnit\Framework\TestCase;
use followed\framed\Container\Container;
use followed\framed\Container\ContainerException;

class ContainerTest extends TestCase
{

    public function test_a_service_can_be_retrieved_from_the_container()
    {   
      //setup
      $container = new Container();
      //do stuff
      // id string, concrete class name string | object 
      $container->add('dependant-class',Dependant::class);


      //assert
      $this->assertInstanceOf(Dependant::class, $container->get('dependant-class')); 
    }
    public function test_a_ContainerException_is_thrown_when_the_service_does_not_exist()
    {
        $container = new Container();
        $this->expectException(ContainerException::class);
        $container->add('eoobar');
    }

    public function test_a_service_that_will_check_if_service(){
    
      $container = new Container();
      $container->add('dependant-class',Dependant::class);
      $this->assertTrue($container->has('dependant-class')); 
      $this->assertFalse($container->has('eoobar'));
        
    }
    public function test_services_can_be_recursively_autowired()
    {
        $container = new Container();

        $container->add('dependant-service', Dependant::class);

        $dependantService = $container->get('dependant-service');

        $this->assertInstanceOf(Dependency::class, $dependantService->getDependency());
    }
}
