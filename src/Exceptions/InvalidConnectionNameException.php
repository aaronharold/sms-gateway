<?php

namespace Aaronharold\SmsGateway\Exceptions;

use Exception;

class InvalidConnectionNameException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(
        $message = 'Invalid SMS connection name. Please add/ensure a valid connection is added on sms gateway config file.',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
