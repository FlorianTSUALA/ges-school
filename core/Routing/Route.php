<?php

namespace Core\Routing;

use ReflectionFunction;
use ReflectionParameter;
use ReflectionClass;

class Route {

  /*  private string $name; 
    private string $path; 
    private $callable;

*/
    public function __construct(string $name,string $path, $callable)
    {
        $this->name = $name;
        $this->path = $path;
        $this->callable = $callable;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getCallable()
    {
        return $this->callable;
    }
    
    public function test(string $path): bool
    {
        $pattern = str_replace("/", "\/", $this->path);
        $pattern = sprintf("/^%s$/", $pattern);  
        $pattern =  preg_replace("/(\{\w+\})/", "(.+)", $pattern);
        return preg_match_all($pattern, $path);
    }
 
    public function call(string $path)
    {
        $pattern = str_replace("/", "\/", $this->path);
        $pattern = sprintf("/^%s$/", $pattern);  
        $pattern = preg_replace("/(\{\w+\})/", "(.+)", $pattern);
        preg_match($pattern, $path, $matches);
        array_shift($matches);

        preg_match_all("/\{(\w+)\}/", $this->path, $paramMatches);
        array_shift($paramMatches);
        //var_dump($matches, $paramMatches[0]);
        $argValues = [];
   
        if( count($paramMatches)>0 ){
            
            $parameters = array_combine($paramMatches[0], $matches);
            
            //is array alway work
            if(is_array($this->callable)){
                //if(! $this->callable instanceof Closure){
                $reflectionFun = (new ReflectionClass($this->callable[0]))->getMethod($this->callable[1]);
            }else{
                $reflectionFun = new ReflectionFunction($this->callable);
            }
            
            $argValues = array_map( function (ReflectionParameter $parameter) use ($parameters) {
                    return $parameters[$parameter->getName()];   
                }, 
                $reflectionFun->getParameters()
            );
        }

        $callable = $this->callable;
        if(is_array($callable)){
            $callable = [ new $callable[0], $callable[1] ];
        }
        return call_user_func_array($callable, $argValues);
    }
}