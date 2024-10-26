<?php

namespace Aaronharold\SmsGateway\Exceptions;

use Exception;

class RequestFailedException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(
        $message = 'HTTP Request has failed.',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
