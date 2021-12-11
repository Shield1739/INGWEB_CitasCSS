<?php

namespace Shield1739\UTP\CitasCss\fluentpdo;

use Exception;

/**
 * Class Exception
 */
class FluentPdoException extends Exception
{
    protected $code = 500;
    protected $message = 'Db Error';
}
