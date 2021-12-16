<?php

namespace Shield1739\UTP\CitasCss\core;

use JetBrains\PhpStorm\Pure;

class Session
{
    public const SUCCESS_KEY = 'success';
    public const USER_KEY = 'user';
    public const USER_TYPE_KEY = 'userType';

    protected const FLASH_KEY = 'flash-messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as &$flashMessage)
        {
            // MARK TO BE REMOVED
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    #[Pure] public function isAuth(): bool
    {
        return $this->get(Session::USER_KEY);
    }

    //TODO TAKE OUT OF CORE
    #[Pure] public function isAdmin(): bool
    {
        return $this->isAuth() && $this->get(self::USER_TYPE_KEY) === 1;
    }

    #[Pure] public function isPaciente(): bool
    {
        return $this->isAuth() && $this->get(self::USER_TYPE_KEY) === 2;
    }

    #[Pure] public function isDoctor(): bool
    {
        return $this->isAuth() && $this->get(self::USER_TYPE_KEY) === 3;
    }


    public function __destruct()
    {
        $this->removeFlashMessages();
    }

    private function removeFlashMessages()
    {
        // Iterate over marked flashed messages
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage)
        {
            // Mark to be removed
            if ($flashMessage['remove'])
            {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}