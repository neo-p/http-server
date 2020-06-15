<?php 
namespace NeoP\Http\Server\Route;

class RouteProvider 
{
    private static $routes = [];

    private static $groups = [];

    public static function addRoute(string $route, callable $callable): void
    {
        self::$routes[$route] = $callable;
    }

    public static function checkRoute(string $route): bool
    {
        return isset(self::$routes[$route]);
    }

    public static function getRoute(string $route): callable
    {
        return self::$routes[$route];
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