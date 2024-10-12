<?php

namespace Aaronharold\SmsGateway;

use Illuminate\Support\Facades\Http;
use Aaronharold\SmsGateway\Contracts\Message;

class SMS extends SmsGatewayService implements Message
{
    private static $AVAILABLE_PROVIDER = ['m360', 'promotexter'];

    public function __construct(?array $config = null)
    {
        $this->onConnection();

        if ($config) {
            $this->body($config);
        }
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
            ->post($url, $this->formatRequestBody());

        if ($response->successful()) {
            return $response->json();
        }

        return $response->json();
    }

    protected function formatRequestBody()
    {
        if (!array_key_exists($this->connection, self::$AVAILABLE_PROVIDER)) {

            // Array values are based on their docs and per request url type eg: broadcast for m360
            $keys = [
                'm360' => [
                    'msisdn' => 'to', // m360 => gateway default 
                    'content' => 'text',
                ],
                'promotexter' => [
                    'to' => 'to',
                    'text' => 'text',
                    'messages' => 'messages',
                ],
            ];

            if (isset($keys[$this->connection])) {
                foreach ($keys[$this->connection] as $key => $value) {
                    if (isset($this->body[$value])) {
                        $this->body[$key] = $this->body[$value];
                        unset($this->body[$value]);
                    }
                }
            }
        }

        // Connection is overridden
        return $this->body;
    }
}
