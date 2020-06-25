<?php

namespace NeoP\Http\Server\Message;

class Parser
{
    public static function protobufPack(string $data)
    {
        return pack('CN', 0, strlen($data)) . $data;
    }

    public static function protobufUnPack(string $data)
    {
        return substr($data, 5);
    }
}
