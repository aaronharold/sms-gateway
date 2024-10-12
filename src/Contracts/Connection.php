<?php

namespace Aaronharold\SmsGateway\Contracts;

use Illuminate\Support\Facades\Http;

interface Connection
{
    /**
     *  SMS Initialized Connection
     */
    public Http $http = null;

    /**
     * SMS Configuration
     */
    public array $headers = [];

    public array $body = [];
    /**
     * SMS Config Available Connection Name eg: m360 || promotexter
     */
    public string $connection;

    public function initializeConnection(?array $config): self;

    public function getConnectionName(): string;

    public function onConnection(string $name): self;

    public function headers(array $headers = []): self;

    public function body(array $body = []): self;

    public function getConnectionDetails();
}
