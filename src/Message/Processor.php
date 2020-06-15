<?php

namespace NeoP\Http\Server\Message;

use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use NeoP\Server\Context;
// use NeoP\Http\Message\Response;

class Processor
{
    public static function messageProcessing(SwooleRequest $request, SwooleResponse $response)
    {
        self::requestProcessing($request);
        self::responseProcessing($response);
    } 

    public static function requestProcessing(SwooleRequest $request)
    {
        $request = new Request($request);
        Context::set(Context::REQUEST, $request);
    } 

    public static function responseProcessing(SwooleResponse $response)
    {
        $response = new Response($response);
        Context::set(Context::RESPONSE, $response);
    } 
}