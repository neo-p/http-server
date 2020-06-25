<?php

use NeoP\Server\Context;
use NeoP\Http\Server\GrpcServer;

if (!function_exists('stdout')) {
    /**
     * 标准输出
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function stdout(...$messages)
    {
        $service = service('server.service');
        $isGrpc = $service === GrpcServer::class;
        if ($isGrpc) {
            $response = Context::get(Context::RESPONSE);
            $resp = '';
        } else {
            $resp = new stdClass();
            $resp->code = 0; 
            $resp->data = new stdClass();
            $resp->message = '';
        }
        foreach ($messages as $value) {
            switch (true) {
                case is_string($value):
                    if ($isGrpc) {
                        $response->withTrailer('grpc-message', $value);
                    } else {
                        $resp->message = $value;
                    }
                    break;

                case is_array($value) || is_object($value):
                    if ($isGrpc) {
                        $resp = $value;
                    } else {
                        // 转对象
                        if (is_array($value)) {
                            $firstIndex = key($value);
                            if (is_int($firstIndex) || $firstIndex == intval($firstIndex)) {
                                $data = new stdClass();
                                $data->list = $value;
                                $value = $data;
                            }
                        }
                        $resp->data = $value;
                    }
                    break;

                case is_int($value):
                    if ($isGrpc) {
                        $response->withTrailer('grpc-status', $value);
                    } else {
                        $resp->code = $value;
                    }
                    break;
            }
        }
        return $resp;
    }
}