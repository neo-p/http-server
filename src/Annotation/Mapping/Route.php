<?php

namespace NeoP\Http\Server\Annotation\Mapping;

use NeoP\Annotation\Annotation\Mapping\AnnotationMappingInterface;
use Doctrine\Common\Annotations\Annotation\Required;
use NeoP\Http\Server\Route\Method;

use function annotationBind;

/** 
 * @Annotation 
 * @Target({"CLASS", "METHOD"})
 * @Attributes({
 *     @Attribute("route", type="string"),
 *     @Attribute("method", type="string"),
 *     @Attribute("middlewares", type="array"),
 * })
 *
 */
final class Route  extends Method implements AnnotationMappingInterface
{
    /**
     * @Required()
     */
    private $route;
    
    private $method = '';
    
    private $middlewares = [];

    private $protobuf = '';

    function __construct($params)
    {
        annotationBind($this, $params, 'setRoute');
    }

    public function setRoute(?string $route = '/'): void
    {
        $this->route = $route;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function setProtobuf(string $protobuf): void
    {
        $this->protobuf = $protobuf;
    }

    public function getProtobuf(): string
    {
        return $this->protobuf;
    }
}