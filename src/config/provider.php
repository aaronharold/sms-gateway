<?php

namespace Aaronharold\SmsGateway\config;

class Provider
{
    public static $MESSAGE_PROVIDER = [
        'm360' => \Aaronharold\SmsGateway\SMS\Providers\M360::class,
        'promotexter' => \Aaronharold\SmsGateway\SMS\Providers\Promotexter::class,
    ];
}
