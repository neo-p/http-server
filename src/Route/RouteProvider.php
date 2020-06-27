<?php 
namespace NeoP\Http\Server\Route;

use NeoP\Http\Server\Route\RouteEntity;

class RouteProvider 
{
    private static $routes = [];

    private static $groups = [];

    public static function addRoute(string $method, string $route, RouteEntity $routeEntity): void
    {
        self::$routes[$method][$route] = $routeEntity;
    }

    public static function checkRoute(string $method, string $route): bool
    {
        return isset(self::$routes[$method][$route]);
    }

    public static function getRoute(string $method, string $route): RouteEntity
    {
        return self::$routes[$method][$route];
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function addRouteGroup(string $class, RouteEntity $group): void
    {
        self::$groups[$class] = $group;
    }

    public static function getRouteGroup(string $class): RouteEntity
    {
        return self::$groups[$class];
    }

    public static function getRouteGroups(): array
    {
        return self::$groups;
    }
}