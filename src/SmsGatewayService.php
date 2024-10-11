<?php

namespace Aaronharold\SmsGateway;

class SmsGatewayService implements SmsInterface
{
    public function checkConnection()
    {
        return 'working...';
    }
}
