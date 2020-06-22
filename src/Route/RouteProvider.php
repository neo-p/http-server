<?php 
namespace NeoP\Http\Server\Route;

class RouteProvider 
{
    private static $routes = [];

    private static $groups = [];

    public static function addRoute(string $method, string $route, callable $callable): void
    {
        self::$routes[$method][$route] = $callable;
    }

    public static function checkRoute(string $method, string $route): bool
    {
        return isset(self::$routes[$method][$route]);
    }

    public static function getRoute(string $method, string $route): callable
    {
        return self::$routes[$method][$route];
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function addRouteGroup(string $class, string $group): void
    {
        self::$groups[$class] = $group;
    }

    public static function getRouteGroup(string $class): string
    {
        return self::$groups[$class];
    }

    public static function getRouteGroups(): array
    {
        return self::$groups;
    }
}