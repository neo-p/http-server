<?php declare(strict_types=1);

namespace NeoP\Http\Server;

use NeoP\Http\Server\HttpServer;
use NeoP\Http\Server\Exception\GrpcException;
use Swoole\Process;
use NeoP\Http\Server\Events\RequestEvent;
use NeoP\DI\Annotation\Mapping\Depend;
use NeoP\Server\Contract\ServiceInerface;
use NeoP\Server\Listener\SwooleListener;
use NeoP\Http\Server\Events\EventType;
use ReflectionMethod;

/**
 * @Depend()
 * @var GrpcServer
 */
class GrpcServer extends HttpServer
{
    
    public function beforeStart()
    {
        echo "gRPC server starting...\r\n";
        echo "listenning ---| HOST: " . $this->host . " | PORT: " . $this->port . " |--- \r\n";
    }
    
    
    public function init(string $host, int $port, int $mode, array $setting): void
    {
        $this->host = $host;
        $this->port = $port;
        $this->mode = $mode;
        $this->setting = $setting;
        $this->options = service('server.options', []);
        $this->optionsParser();
        $this->checkHttp2();
        $this->newServer();
    }

    public function checkHttp2() {
        if (! isset($this->setting['open_http2_protocol']) || $this->setting['open_http2_protocol'] == false ) {
            throw new GrpcException("gRPC server must be http 2.0 protocol, please enable `open_http2_protocol`");
        }
    }

}
