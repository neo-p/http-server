<?php

namespace NeoP\Http\Server\Events;

use Swoole\Http\Request;
use Swoole\Http\Response;
use NeoP\Server\Context;
use Swoole\Coroutine;
use NeoP\Server\Middleware\MiddlewareHandler;
use NeoP\Server\Annotation\Mapping\SwooleEvent;
use NeoP\Http\Server\Events\EventType;
use NeoP\Http\Server\Message\Processor;
use NeoP\Http\Server\Service\Service;
use NeoP\Http\Server\Exception\HttpExitException;
use \Exception;

/**
 * @SwooleEvent(EventType::ON_REQUEST, type=EventType::LISTEN_HTTP)
 */
class OnRequestEvent
{
    public function handler(Request $request, Response $response)
    {
        // TODO
        // Request & Response
        Processor::messageProcessing($request, $response);

        // 抛错直接中断所有后续事件
        try {
            // Middleware
            MiddlewareHandler::handler();
            // Service 
            Service::execute();
            // Action
            Context::get(Context::RESPONSE)->send();
        } catch (Exception $error) {

            if ($error instanceof HttpExitException) {
                $response = Context::get(Context::RESPONSE);
                $response->status($error->getCode(), $error->getMessage())
                        ->content($error->getMessage())
                        ->send();
            } else {
                throw $error;
            }

        }
    }

}
