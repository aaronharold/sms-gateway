<?php

namespace Aaronharold\SmsGateway;

use Illuminate\Support\Facades\Http;
use Aaronharold\SmsGateway\Contracts\Message;

class SMS extends SmsGatewayService implements Message
{
    public function __construct()
    {
        $this->onConnection();
    }

    public function recipient(string $number, string $key = 'to')
    {
        // Todo: Implements a number formatter and telco provider identification
        $this->body([$key => $number]);
        return $this;
    }

    public function message(string $message, string $key = 'text')
    {
        // Todo: Add functionality to cater view/blade and other type of message
        $this->body([$key => $message]);
        return $this;
    }

    public function sendToMany(array $recipients, string $key = 'messages')
    {
        // Todo: Implements a number formatter and telco provider identification and Message types
        $this->body([$key => $recipients]);
        return $this;
    }

    public function setBaseRequestUrl(string $url)
    {
        $this->body(['url' => $url]);
        return $this;
    }

    public function setRequestUrl(string $url)
    {
        $this->body(['url' =>  $this->body['url'] . '/' .  $url]);
        return $this;
    }

    public function send()
    {
        $url = $this->body['url'];
        unset($this->body['url']);

        $response = Http::withHeaders($this->headers)
            ->post($url, $this->body);

        if ($response->successful()) {
            return $response->json();
        }

        return $response->json();
    }
}
