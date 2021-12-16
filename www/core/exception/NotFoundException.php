<?php

namespace Shield1739\UTP\CitasCss\core\exception;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'Pagina no Encontrada';
    protected $code = 404;
}