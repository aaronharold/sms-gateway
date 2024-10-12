<?php

namespace Aaronharold\SmsGateway;

use Aaronharold\SmsGateway\Contracts\Message;

class SMS extends SmsGatewayService implements Message
{
    public function recipient(string $key = 'to', string $number)
    {
        // Todo: Implements a number formatter and telco provider identification
        $this->body([$key => $number]);
        return $this;
    }

    public function message(string $key = 'text', string $message)
    {
        // Todo: Add functionality to cater view/blade and other type of message
        $this->body([$key => $message]);
        return $this;
    }

    public function sendToMany(string $key = 'messages', array $recipients)
    {
        // Todo: Implements a number formatter and telco provider identification and Message types
        $this->body([$key => $recipients]);
        return $this;
    }

    public function send()
    {
        $this->initializeConnection();

        $url = $this->body['url'];
        unset($this->body['url']);

        $response = $this->http->post($url, $this->body);
        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to send sms: ' . $response->body());
    }
}
