<?php

namespace NeoP\Http\Server\Annotation\Handler;

use NeoP\DI\Container;
use NeoP\Annotation\Annotation\Handler\Handler;
use NeoP\Annotation\Annotation\Mapping\AnnotationHandler;
use NeoP\Http\Server\Annotation\Mapping\Route;
use NeoP\Http\Server\Route\RouteProvider;
use NeoP\Http\Server\Route\RouteEntity;
use NeoP\Http\Server\GrpcServer;
use NeoP\Http\Server\Exception\GrpcException;
use NeoP\Http\Server\Route\Method;
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
        $method = strtoupper($annotation->getMethod());
        $middlewares = $annotation->getMiddlewares();
        $protobuf = $annotation->getProtobuf();
        if ($reflection instanceof ReflectionClass) {
            $route = $this->rmSuffix(
                $this->addPrefix($route)
            );
            $routeEntity = new RouteEntity(
                $method,
                $route,
                $middlewares
            );
            RouteProvider::addRouteGroup($this->className, $routeEntity);
        } elseif ($reflection instanceof ReflectionMethod) {
            $class = $this->className;
            $methodName = $reflection->getName();
            if (! $route) {
                $route = $methodName;
            }
            $newRoute = $this->addPrefix($route);
            $parent = RouteProvider::getRouteGroup($class);
            if ($newRoute != $route) {
                $route = $parent->getMapping() . $newRoute;
            }
            if ($method == "") {
                $method =$parent->getMethod() ?? Method::GET;
            }
            $service = service('server.service');
            if ($service === GrpcServer::class) {
                if ($protobuf) {
                    if (! class_exists($protobuf)) {
                        throw new GrpcException("Grpc error: protobuf [" . $protobuf . "] is not use.");
                    }
                } else {
                    throw new GrpcException("Grpc error: Class [" . $class . "] Method [" . $methodName . "] @Route params:protobuf is not defined.");
                }
            }
            $routeEntity = new RouteEntity(
                $method,
                $route,
                $middlewares,
                $protobuf,
                $reflection->getClosure(Container::getDefinition($this->className))
            );
            RouteProvider::addRoute($method, $route, $routeEntity);
        }
    }

    protected function rmSuffix(?string $str = '/', string $suffix = "/")
    {
        if (substr($str, -1, 1) == $suffix) {
            $str = substr($str, 0, -1);
        }
        return $str;
    } 

    protected function addPrefix(?string $str = '/', string $prefix = "/")
    {
        if (substr($str, 0, 1) != $prefix) {
            $str = $prefix . $str;
        }
        return $str;
    } 
}