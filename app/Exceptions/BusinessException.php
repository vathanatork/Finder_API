<?php

namespace App\Exceptions;

use Throwable;
use Exception;

class BusinessException extends Exception
{
    private mixed $customStatusCode;

    public function __construct($message, $code = 404, $customStatusCode = 400, Throwable $previous = null)
    {
        $this->customStatusCode = $customStatusCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int|mixed
     */
    public function getCustomStatusCode(): mixed
    {
        return $this->customStatusCode;
    }
}
