<?php

namespace Aaronharold\SmsGateway\Contracts;

interface Message
{
    public function recipient(string $key = 'to', string $number);
    public function message(string $key = 'text', string $message);
    public function sendToMany(string $key = 'messages', array $recipients);
    public function send();
}
