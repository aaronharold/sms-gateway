<?php

namespace Aaronharold\SmsGateway\Contracts;

interface IMessage
{
    public function onConnection(string $name): self;
    public function sendMessage(string $number, string $message = '');
    public function sendBatchMessage(array $data);
}
