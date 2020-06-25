<?php declare(strict_types=1);

namespace NeoP\Http\Server;

use Swoole\Http\Server as SwooleServer;
use Swoole\Process;
use NeoP\Log\Log;
use NeoP\Http\Server\Events\RequestEvent;
use NeoP\DI\Annotation\Mapping\Depend;
use NeoP\Server\Contract\ServiceInerface;
use NeoP\Server\Listener\SwooleListener;
use NeoP\Http\Server\Events\EventType;
use NeoP\Http\Server\Middleware\NotFoundMiddleware;
use NeoP\Server\Middleware\MiddlewareProvider;
use ReflectionMethod;

/**
 * @Depend()
 * @var GrpcServer
 */
class GrpcServer extends Http2Server implements ServiceInerface
{

    public function beforeStart()
    {
        Log::info("gRPC Server starting...", 0, Log::MODE_DEFAULT, Log::FG_WHITE);
        Log::info("---| HOST: " . $this->host . " | PORT: " . $this->port . " |--- ", 0, Log::MODE_DEFAULT);
    }

}
