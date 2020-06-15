<?php
namespace NeoP\Http\Server\Message;

use Swoole\Http\Request as SwooleRequest;
use NeoP\Http\Message\ServerRequest;

class Request extends ServerRequest
{
    function __construct(SwooleRequest $swooleRequest)
    {
        parent::__construct($swooleRequest);
    }

    public function get(?string $key = NULL, $default = NULL)
    {
        $query = $this->getQueryParams();

        if ($key === NULL) {
            return $query;
        }

        if (isset($query[$key])) {
            return $query[$key];
        }

        return $default;
    }

    public function post(?string $key = NULL, $default = NULL)
    {
        $post = $this->getParsedBody();

        if ($key === NULL) {
            return $post;
        }

        if (isset($post[$key])) {
            return $post[$key];
        }

        return $default;
    }

    public function header(string $key, $default = NULL)
    {
        
        $headers = $this->getParsedBody();

        if (isset($headers[$key])) {
            return $headers[$key];
        }

        return $default;
    }

    public function headers(?string $key = NULL, $default = NULL)
    {
        
        $headers = $this->getParsedBody();

        if ($key === NULL) {
            return $headers;
        }
        
        if (isset($headers[$key])) {
            return $headers[$key];
        }

        return $default;
    }
}
