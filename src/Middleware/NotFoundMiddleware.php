<?php

namespace NeoP\Http\Server\Middleware;

use NeoP\Server\Annotation\Mapping\Middleware;
use NeoP\Http\Server\Route\RouteProvider;
use NeoP\Server\Context;

/**
 * @Middleware()
 */
class NotFoundMiddleware
{
    public function handler()
    {
        /**
         * 应该先检测路由
         */
        // $request = Context::get(Context::REQUEST);
        // $route = $request->getUri()->getPath();
        // if (RouteProvider::checkRoute($route)) {
        //     $response = Context::get(Context::RESPONSE);
        //     $response->exit(404, "Not found page");
        // }
    }
}
