<?php

namespace Aaronharold\SmsGateway\Contracts;

interface Message
{
    public function recipient(string $number, string $key = 'to');
    public function message(string $message, string $key = 'text');
    public function sendToMany(array $recipients, string $key = 'messages');
    public function setBaseRequestUrl(string $url);
    public function setRequestUrl(string $url);
    public function send();
}
