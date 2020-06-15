<?php

namespace NeoP\Http\Server\Service;

use NeoP\Http\Server\Route\RouteProvider;
use NeoP\Http\Server\Message\Response;
use NeoP\Server\Context;

class Service 
{
    public static function execute()
    {
        $request = Context::get(Context::REQUEST);
        $response = Context::get(Context::RESPONSE);
        $route = $request->getUri()->getPath();
        if (RouteProvider::checkRoute($route)) {
            $data = RouteProvider::getRoute($route)();
            if (!($data instanceof Response)) {
                if (is_array($data) || is_object($data)) {
                    $response->json($data);
                } elseif (is_string($data) || is_int($data)) {
                    $response->content((string) $data);
                }
            }
        } else {
            $response->exit(404, "Not found page");
        }
    }
}