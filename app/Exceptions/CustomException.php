<?php


namespace App\Exceptions;

use Exception;


class CustomException extends Exception
{
    /**
     * An array of more specific error messages to be sent to the client.
     *
     * @var array
     */
    protected $errorMessages = [];

    public function __construct(string $message = "", int $code = 0
        , array $errorMessages = [], \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->errorMessages = $errorMessages;
    }

    public function getErrorMessages() {
        return $this->errorMessages;
    }

}
