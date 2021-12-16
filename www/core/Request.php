<?php

namespace Shield1739\UTP\CitasCss\core;

use JetBrains\PhpStorm\Pure;

/**
 * Processes URI requests and fetches the Request method and data
 */
class Request
{
    /**
     * Returns clean URI path without variables
     *
     * @return mixed
     */
    public function getPath(): mixed
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false)
        {
            return $path;
        }

        return substr($path, 0, $position);
    }

    /**
     * Normalizes and returns the Requests method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    #[Pure] public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * @return bool
     */
    #[Pure] public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Sanitizes and return Request data
     *
     * @return array
     */
    #[Pure] public function getSanitizedData(): array
    {
        $data = [];

        if ($this->isGet())
        {
            foreach ($_GET as $key => $value)
            {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost())
        {
            foreach ($_POST as $key => $value)
            {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $data;
    }
}