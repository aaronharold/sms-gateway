<?php

namespace Aaronharold\SmsGateway\Exceptions;

use Exception;

class InvalidMessageProviderException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(
        $message = 'Invalid connection no message provider. If you want to use your own provider please initialize on the SMS constructor.',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
