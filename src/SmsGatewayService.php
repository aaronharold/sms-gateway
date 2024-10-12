<?php

namespace Aaronharold\SmsGateway;

use Aaronharold\SmsGateway\Contracts\Connection;
use Aaronharold\SmsGateway\Exceptions\ConfigNotFoundException;
use Aaronharold\SmsGateway\Exceptions\InvalidConnectionNameException;
use Aaronharold\SmsGateway\Exceptions\InvalidConfigurationTypeException;

class SmsGatewayService implements Connection
{
    /**
     * SMS Configuration
     */
    public array $headers = [
        'Accept' => 'application/json'
    ];

    public array $body = [];
    /**
     * SMS Config Available Connection Name eg: m360 || promotexter
     */
    public string $connection;

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
        return $this->body;
    }

    public function onConnection(string $name = 'default'): self
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
