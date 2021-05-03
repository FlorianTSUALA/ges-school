<?php

namespace Core\Routing;

use Core\Routing\Route;
use Core\Routing\RouteNotFoundException;

class Router{

    public function __constuct(){
        $this->routes = [] ;
    }

    public function getRouteCollection(): array
    {
        return $this->routes;
    }

    public function add(Route $route):self
    {

        
        if($this->has($route->getName()))
            throw new RouteAlreadyExistsException();
        
        $this->routes[$route->getName()] = $route;
        return $this;
    }

    public function addRoute(string $name,string $path, $callable):self
    {
        return $this->add(new Route($name, $path, $callable));
    }

    public function crudRoute(string $name,string $controller):self
    {
        $this->addRoute("{$name}", "{$name}", [$controller, "index"]);
        $this->addRoute("{$name}-create", "{$name}/create/", [$controller, "save"]);
        $this->addRoute("{$name}-read", "{$name}/read/{code}", [$controller, "show"]);
        $this->addRoute("{$name}-detail", "{$name}/detail/{code}", [$controller, "detail"]);
        $this->addRoute("{$name}-update", "{$name}/update/{code}", [$controller, "update"]);
        $this->addRoute("{$name}-all", "{$name}/all/", [$controller, "list"]);
        return $this->addRoute("{$name}-delete", "{$name}/delete/{code}", [$controller, "delete"]);
    }

    public function get(string $name): ?Route
    {
        if(!$this->has($name))
            throw new RouteNotFoundException();
        return $this->routes[$name];
    }


    public function has(string $name)           
    {
        return isset($this->routes[$name]);
    }
 
    public function match(string $path): Route           
    {
        foreach($this->routes as $route){
            if($route->test($path)){
                return $route;
            }
        }
        throw new RouteNotFoundException();
    }

    public function call(string $path)
    {
        return $this->match($path)->call($path);
    }

}