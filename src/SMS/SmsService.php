<?php

namespace Aaronharold\SmsGateway\SMS;

use Illuminate\Support\Facades\Http;
use Aaronharold\SmsGateway\Exceptions\RequestFailedException;
use Aaronharold\SmsGateway\Exceptions\ConfigNotFoundException;
use Aaronharold\SmsGateway\Exceptions\InvalidConnectionNameException;
use Aaronharold\SmsGateway\Exceptions\InvalidConfigurationTypeException;

class SmsService
{
    public string $connection = 'default';
    public string $url = '';
    public array $body = [];
    public array $headers = [
        'Accept' => 'application/json'
    ];
    public static string $GET  = 'get';
    public static string $POST = 'post';

    public function __construct(
        ?string $connection = null,
        ?string $url = null,
        ?array $config = null
    ) {
        $this->setupConnection($connection);
    }

    public function setupConnection(string|null $name = 'default'): self
    {
        $conn = config('smsgateway.connection');

        if (strtolower($name) == 'default') {
            $name = config('smsgateway.default');
        }

        if ($conn === null) {
            throw new ConfigNotFoundException();
        }

        if (!array_key_exists($name, $conn)) {
            throw new InvalidConnectionNameException();
        }

        $this->connection = $name;
        $this->body = [];
        $this->getConnectionDetails();
        $this->geturl();
        return $this;
    }

    public function getConnectionDetails()
    {
        $conn = config("smsgateway.connection." . $this->getConnectionName());

        if ($conn === null) {
            throw new ConfigNotFoundException();
        }

        if (!is_array($conn)) {
            throw new InvalidConfigurationTypeException(
                'Invalid connection type. Expects an array, ' . gettype($conn) . ' given.'
            );
        }

        unset($conn['url']);
        $this->body($conn);
        return $this->body;
    }

    public function getConnectionName(): string
    {
        if (!$this->connection) {
            $conn = config("smsgateway.default");

            if ($conn === null) {
                throw new ConfigNotFoundException();
            }

            $this->connection == $conn;
        }

        return $this->connection;
    }

    public function headers(array $headers = []): self
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function body(array $body = []): self
    {
        $this->body = array_merge($this->body, $body);
        return $this;
    }

    public function geturl(): string
    {
        $conn = config("smsgateway.connection." . $this->getConnectionName());
        $this->url = $conn['url'] ?? '';
        return $this->url;
    }

    protected function send(string $type = 'get' | 'post', string $route = '', array $data = [])
    {
        $response = Http::withHeaders($this->headers);

        $this->body($data);

        if ($type == self::$GET)
            $response = $response->get($this->url . '/' . $route, $this->body);

        if ($type == self::$POST)
            $response = $response->post($this->url . '/' . $route, $this->body);

        if ($response->ok())
            return $response->json();

        throw new RequestFailedException($response->reason(), $response->status());
    }
}
