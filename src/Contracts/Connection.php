<?php

namespace Aaronharold\SmsGateway\Contracts;

interface Connection
{
    public function getConnectionName(): string;

    public function onConnection(string $name): self;

    public function headers(array $headers = []): self;

    public function body(array $body = []): self;

    public function getConnectionDetails();
}
