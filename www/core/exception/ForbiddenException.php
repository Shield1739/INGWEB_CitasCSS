<?php

namespace Shield1739\UTP\CitasCss\core\exception;

use Exception;

class ForbiddenException extends Exception
{
    protected $message = 'No tienes permiso de acceder a esta pagina';
    protected $code = 403;
}