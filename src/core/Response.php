<?php

namespace Shield1739\UTP\CitasCss\core;

/**
 * Deals with HTTP response
 */
class Response
{
    /**
     * @param int $code
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    /**
     * @param string $url
     */
    public function redirect(string $url)
    {
        header('Location: '.$url);
    }
}