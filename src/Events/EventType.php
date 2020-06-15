<?php

namespace NeoP\Http\Server\Events;

use NeoP\Server\Events\EventType as ServerEventType;

class EventType extends ServerEventType
{
    const ON_REQUEST = "request";
    const LISTEN_HTTP = 2;
}
