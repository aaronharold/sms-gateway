<?php

namespace Aaronharold\SmsGateway\Exceptions;

use Exception;

class ConfigNotFoundException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(
        $message = 'SMS Config not found. Run php artisan vendor:publish --tag=smsgateway-config',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
