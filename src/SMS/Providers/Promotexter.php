<?php

namespace Aaronharold\SmsGateway\SMS\Providers;

use Aaronharold\SmsGateway\SMS\SmsService;
use Aaronharold\SmsGateway\Contracts\IMessage;

class Promotexter extends SmsService implements IMessage
{
    public function __construct()
    {
        parent::__construct(config('smsgateway.default'));
    }

    public function onConnection(string $name = 'default'): self
    {
        $this->setupConnection($name);
        return $this;
    }

    public function sendMessage(string $number, string $message = '')
    {
        throw new \Exception($this::class . '. Method not implemented sendMessage');
    }

    public function sendBatchMessage(array $data)
    {
        throw new \Exception($this::class . '. Method not implemented sendBatchMessage');
    }
}
