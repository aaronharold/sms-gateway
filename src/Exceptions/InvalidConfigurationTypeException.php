<?php

namespace Aaronharold\SmsGateway\Exceptions;

use Exception;

class InvalidConfigurationTypeException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(
        $message = 'Invalid configuration type',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
