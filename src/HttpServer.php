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
use ReflectionMethod;
use NeoP\Http\Server\Middleware\NotFoundMiddleware;
use NeoP\Server\Middleware\MiddlewareProvider;
use NeoP\Http\Server\Exception\HttpConfigException;

/**
 * @Depend()
 * @var HttpServer
 */
class HttpServer implements ServiceInerface
{
    protected $server;
    protected $host;
    protected $port;
    protected $mode;
    protected $setting;
    protected $options;
    protected $sockType;

    public function beforeStart()
    {
        Log::info("HTTP Server starting...", 0, Log::MODE_DEFAULT, Log::FG_WHITE);
        Log::info("---| HOST: " . $this->host . " | PORT: " . $this->port . " |--- ", 0, Log::MODE_DEFAULT);
    }

    public function init(string $host, int $port, int $mode, array $setting): void
    {
        $this->host = $host;
        $this->port = $port;
        $this->mode = $mode;
        $this->setting = $setting;
        $this->options = service('server.options', []);
        $this->sockType = SWOOLE_SOCK_TCP;
        $this->optionsParser();
        $this->afterSetting();
        $this->registerMiddleware();
        $this->newServer();
    }

    public function newServer()
    {
        $this->server = new SwooleServer($this->host, $this->port, $this->mode, $this->sockType);
        $this->server->set($this->setting);
    }

    public function on(string $event, callable $callback): void
    {
        $this->server->on($event, $callback);
    }
    
    public function registerEvent(): void
    {
        if (SwooleListener::hasListens(EventType::LISTEN_HTTP)) {
            foreach (SwooleListener::getListens(EventType::LISTEN_HTTP) as $event => $callback) {
                $this->server->on($event, $callback);
            }
        }
    }
    
    public function registerMiddleware()
    {
        MiddlewareProvider::addServiceMiddleware(NotFoundMiddleware::class);
    }

    public function start(): void
    {
        $this->beforeStart();
        $this->server->start();
    }
    
    public function reload(): void
    {
        $this->server->reload();
    }
    
    public function addProcess(Process $process): int
    {
        return $this->server->addProcess($process);
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function optionsParser(): void
    {
        if (isset($this->options['setting'])) {
            foreach ($this->options['setting'] as $key => $value) {
                $this->setting[$key] = $value;
            }
        }

        if (isset($this->options['ssl']) && $this->options['ssl']['enable']) {
            if (! isset($this->options['ssl']['cert']) || ! isset($this->options['ssl']['key'])) {
                throw new HttpConfigException("SSL error: Please make sure to fill in the ssl key and cert.");
            }
            $this->setting['ssl_cert_file'] = $this->options['ssl']['cert'];
            $this->setting['ssl_key_file'] = $this->options['ssl']['key'];
            $this->sockType = SWOOLE_SOCK_TCP | SWOOLE_SSL;
        }


    }
    
    public function afterSetting(): void
    {
    }
    
}
