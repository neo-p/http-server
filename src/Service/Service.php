<?php

namespace NeoP\Http\Server\Service;

use NeoP\Http\Server\Route\RouteEntity;
use NeoP\Http\Server\Route\RouteProvider;
use NeoP\Http\Server\Message\Response;
use NeoP\Http\Server\Message\Codes;
use NeoP\Http\Server\Exception\RouteException;
use NeoP\Http\Server\Message\Parser;
use NeoP\Http\Server\GrpcServer;
use NeoP\Http\Server\Http2Server;
use NeoP\Server\Context;


class Service 
{
    public static function execute()
    {
        $request = Context::get(Context::REQUEST);
        $response = Context::get(Context::RESPONSE);
        $route = $request->getUri()->getPath();
        $method = $request->getMethod();
        
        $service = service('server.service');
        if (RouteProvider::checkRoute($method, $route)) {
            $routeEntity = RouteProvider::getRoute($method, $route);
            if ($routeEntity instanceof RouteEntity) {

                // struct mode
                if (service('server.options.struct') === true) {
                    if ($service === Http2Server::class || $service === GrpcServer::class) {

                        if ($request->getProtocolVersion() !== '2') {
                            $response->exit(Codes::HTTP_SWITCHING_PROTOCOLS, "Protocol error");
                        }

                        if ($service === GrpcServer::class) {
                            $contentType = $request->getHeader('content-type') ?? [];
                            if (! in_array('application/grpc', $contentType)) {
                                $response->exit(Codes::HTTP_SWITCHING_PROTOCOLS, "Protocol error");
                            }
                        }
                    }
                }

                // execute logic
                $protobuf = $routeEntity->getProtobuf();
                if ($protobuf != '') {
                    $request->protobuf = new $protobuf();
                    $request->protobuf->mergeFromString(
                        Parser::protobufUnPack(
                            $request->getBody()->getContents()
                        )
                    );
                }

                $data = $routeEntity->getCallable()();
                if (!($data instanceof Response)) {
                    if (is_a($data, \Google\Protobuf\Internal\Message::class)) {
                        $data = Parser::protobufPack(
                            $data->serializeToString()
                        );
                    }
                    if (is_array($data) || is_object($data)) {
                        $response->json($data);
                    } elseif (is_string($data) || is_int($data)) {
                        $response->content((string) $data);
                    }
                }
            } else {
                throw new RouteException("Route error: Wrong routing entity.");
            }
        } else {
            if ($service === GrpcServer::class) {
                $response->exitGrpc(Codes::GRPC_UNAVAILABLE, "UNAVAILABLE");
            } else {
                $response->exit(Codes::HTTP_NOT_FOUND, "Not found page");
            }
        }
    }

}