<?php

namespace Aaronharold\SmsGateway\SMS;

use Aaronharold\SmsGateway\config\Provider;
use Aaronharold\SmsGateway\Contracts\IMessage;
use Aaronharold\SmsGateway\Exceptions\ConfigNotFoundException;
use Aaronharold\SmsGateway\Exceptions\InvalidConnectionNameException;
use Aaronharold\SmsGateway\Exceptions\InvalidMessageProviderException;

class SMS
{
    private $isCustomProvider = false;

    public function __construct(
        public ?IMessage $messageProvider = null,
        protected $connection = 'default',
    ) {
        // Autoload based on config
        if (!$messageProvider) {
            $this->connection = config('smsgateway.default');
            $this->setMessageProvider();
        } else {
            $this->messageProvider  = $messageProvider;
            $this->isCustomProvider = true;
        }
    }

    protected function setMessageProvider()
    {
        try {
            $this->messageProvider = new Provider::$MESSAGE_PROVIDER[$this->connection]();
        } catch (\Throwable $th) {
            throw new InvalidMessageProviderException(
                'No default message provider for '
                    . $this->connection .
                    '. If you use a custom message provider please add in SMS initialization.'
            );
        }
        return $this;
    }

    public function sendMessage(string $number, string $message = '')
    {
        return $this->messageProvider->sendMessage($number, $message);
    }

    public function sendBatchMessage(array $data)
    {
        return $this->messageProvider->sendBatchMessage($data);
    }

    public function onConnection(string $name = 'default')
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

        $validated = $this->validateProvider();

        if ($this->isCustomProvider == false && !$validated) {
            throw new InvalidMessageProviderException();
        }

        if ($validated) {
            $this->connection = $name;
            $this->setMessageProvider();
        }

        return $this->messageProvider->onConnection($name);
    }

    private function validateProvider(): bool
    {
        $isValid = false;
        foreach (Provider::$MESSAGE_PROVIDER as $providerClass) {
            if ($this->messageProvider instanceof $providerClass) {
                $isValid = true;
                break;
            }
        }
        return $isValid;
    }
}
