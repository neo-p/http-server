<?php

namespace NeoP\Http\Server\Route;

use NeoP\Http\Server\Route\Method;

class RouteEntity
{
    protected $_mapping = '';
    protected $_method = Method::GET;
    protected $_protobuf;
    protected $_middlewares = [];
    protected $_callable;

    function __construct(
        string $method,
        string $mapping,
        array $middlewares,
        ?string $protobuf = null,
        ?callable $callable = null
    ) 
    {
        $this->_mapping = $mapping;
        $this->_method = $method;
        $this->_protobuf = $protobuf;
        $this->_middlewares = $middlewares;
        $this->_callable = $callable;
    }

    public function setMapping(string $mapping): void
    {
        $this->_mapping = $mapping;
    }

    public function getMapping(): string 
    {
        return $this->_mapping;
    }
    
    public function setMethod(string $method): void
    {
        $this->_method = $method;
    }

    public function getMethod(): string 
    {
        return $this->_method;
    }
    
    public function setProtobuf(string $protobuf): void
    {
        $this->_protobuf = $protobuf;
    }

    public function getProtobuf(): string 
    {
        return $this->_protobuf;
    }
    
    public function setMiddlewares(array $middlewares): void
    {
        $this->_middlewares = $middlewares;
    }

    public function getMiddlewares(): array 
    {
        return $this->_middlewares;
    }
    
    public function setCallable(callable $callable): void
    {
        $this->_callable = $callable;
    }

    public function getCallable(): callable 
    {
        return $this->_callable;
    }
}