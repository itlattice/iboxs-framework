<?php

namespace iboxs\swoole\exception;

use Exception;
use iboxs\swoole\rpc\Error;

class RpcResponseException extends Exception
{
    protected $error;

    public function __construct(Error $error)
    {
        parent::__construct($error->getMessage(), $error->getCode());
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }
}
