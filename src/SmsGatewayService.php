<?php

namespace Aaronharold\SmsGateway;

use Illuminate\Support\Facades\Http;
use Aaronharold\SmsGateway\Contracts\Connection;
use Aaronharold\SmsGateway\Exceptions\ConfigNotFoundException;
use Aaronharold\SmsGateway\Exceptions\InvalidConnectionNameException;
use Aaronharold\SmsGateway\Exceptions\InvalidConfigurationTypeException;

class SmsGatewayService implements Connection
{
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

        $this->body($conn);
    }

    public function initializeConnection(array $config = null): self
    {
        $this->getConnectionDetails();

        // Initialize the Http instance without making a request
        $this->http = Http::withHeaders($this->headers);

        // Store the body for later use
        $this->body = $config !== null ? $config : $this->body;

        return $this;
    }

    public function onConnection(string $name = 'default'): self
    {
        $conn = config('smsgateway.connection');

        if (strtolower($name) == 'default') {
            $conn = config('smsgateway.default');
        }

        if ($conn === null) {
            throw new ConfigNotFoundException();
        }

        if (!array_key_exists($name, $conn)) {
            throw new InvalidConnectionNameException();
        }

        $this->connection = $name;
        return $this;
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
}
