<?php

namespace NeoP\Http\Server\Annotation\Handler;

use NeoP\DI\Container;
use NeoP\Annotation\Annotation\Handler\Handler;
use NeoP\Annotation\Annotation\Mapping\AnnotationHandler;
use NeoP\Http\Server\Annotation\Mapping\Route;
use NeoP\Http\Server\Route\RouteProvider;
use ReflectionClass;
use ReflectionMethod;

/**
 * @AnnotationHandler(Route::class)
 */
class RouteHandler extends Handler
{
    public function handle(Route $annotation, $reflection)
    {
        $route = $annotation->getRoute();
        if ($reflection instanceof ReflectionClass) {
            $route = $this->rmSuffix(
                $this->addPrefix($route)
            );
            RouteProvider::addRouteGroup($this->className, $route);
        } elseif ($reflection instanceof ReflectionMethod) {
            $class = $this->className;
            $newRoute = $this->addPrefix($route);
            if ($newRoute != $route) {
                $route = RouteProvider::getRouteGroup($class) . $newRoute;
            }
            RouteProvider::addRoute($route, $reflection->getClosure(Container::getDefinition($this->className)));
        }
    }

    protected function rmSuffix(string $str, string $suffix = "/")
    {
        if (substr($str, -1, 1) == $suffix) {
            $str = substr($str, 0, -1);
        }
        return $str;
    } 

    protected function addPrefix(string $str, string $prefix = "/")
    {
        if (substr($str, 0, 1) != $prefix) {
            $str = $prefix . $str;
        }
        return $str;
    } 
}