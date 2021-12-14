<?php

namespace Shield1739\UTP\CitasCss\core\common;

use DateTime;
use Shield1739\UTP\CitasCss\app\PDOUtils;
use Shield1739\UTP\CitasCss\core\Utilities;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

/**
 *
 */
abstract class Model
{
    public const MODEL_KEY = 'model';
    protected const RULE_REQUIRED = 'required';
    protected const RULE_REQUIRED_WHEN = 'required-when';
    protected const RULE_EMAIL = 'email';
    protected const RULE_CEDULA = 'cedula';
    protected const RULE_MIN = 'min';
    protected const RULE_MAX = 'max';
    protected const RULE_PASSWORD_MATCH = 'password-match';
    protected const RULE_UNIQUE = 'unique';
    protected const RULE_WORK_DAY = 'work-day';

    /**
     * @var array Stores errors found in model validation
     */
    protected array $errors;

    protected PDOUtils $pdoUtils;

    public function __construct()
    {
        $this->errors = [];
        $this->pdoUtils = new PDOUtils();
        $this->init();
    }

    /**
     * Called on constructor
     */
    abstract public function init();

    /**
     * Returns all model attributes
     *
     * @return array
     */
    abstract public function getAllAttributes(): array;

    /**
     * Returns all model rules
     *
     * @return array
     */
    abstract public function getRules(): array;

    /**
     * Returns all model entities
     *
     * @return array
     */
    public function getEntities(): array
    {
        return array_keys($this->getAllAttributes());
    }

    /**
     * Return attributes of a specific entity
     *
     * @param string $entityKey
     *
     * @return array
     */
    public function getEntityAttributes(string $entityKey): array
    {
        return $this->getAllAttributes()[$entityKey];
    }

    /**
     * Loads provided data into model or entities properties
     *
     * @param $data
     */
    public function loadData($data)
    {
        foreach ($data as $key => $value)
        {
            foreach ($this->getAllAttributes() as $object => $attributes)
            {
                if ($object === self::MODEL_KEY && property_exists($this, $key))
                {
                    $this->{$key} = $value;
                    break;
                }
                else if ($object != self::MODEL_KEY && property_exists($this->{$object}, $key))
                {
                    $this->{$object}->{$key} = $value;
                    break;
                }
            }
        }
    }

    /**
     * Validates if the attributes passes all the rule checks.
     * If error is found, adds it to $error and returns false. Else returns true
     *
     * @return bool
     * @throws \Exception
     */
    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->getRules() as $block => $ruleBlock)
        {
            foreach ($ruleBlock as $attr => $rules)
            {
                $value = null;

                if($block === self::MODEL_KEY)
                {
                    $value = $this->{$attr};
                }
                else
                {
                    $value = $this->{$block}->{$attr};
                }

                foreach ($rules as $rule)
                {
                    $ruleName = $rule;
                    if (!is_string($ruleName))
                    {
                        $ruleName = $rule[0];
                    }

                    if ($ruleName === self::RULE_REQUIRED && !$value)
                    {
                        $this->addErrorForRule($attr, self::RULE_REQUIRED);
                    }
                    if ($ruleName === self::RULE_REQUIRED_WHEN && $rule['when'] && !$value)
                    {
                        $this->addErrorForRule($attr, self::RULE_REQUIRED_WHEN);
                    }
                    if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL))
                    {
                        $this->addErrorForRule($attr, self::RULE_EMAIL);
                    }
                    if ($ruleName === self::RULE_CEDULA && Utilities::validateCedula($value) === 0)
                    {
                        $this->addErrorForRule($attr, self::RULE_CEDULA);
                    }
                    if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min'])
                    {
                        $this->addErrorForRule($attr, self::RULE_MIN, $rule);
                    }
                    if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max'])
                    {
                        $this->addErrorForRule($attr, self::RULE_MAX, $rule);
                    }
                    if ($ruleName === self::RULE_PASSWORD_MATCH && $value !== $this->{$rule['passwordField']})
                    {
                        $this->addErrorForRule($attr, self::RULE_PASSWORD_MATCH);
                    }
                    if ($ruleName === self::RULE_UNIQUE)
                    {
                        $uAttribute = $rule['attribute'] ?? $attr;
                        $tableName = $rule['tableName'];

                        $result = null;
                        try
                        {
                            $result = $this->pdoUtils->getFluentPdoBuilder()
                                ->from($tableName)->where($uAttribute, $value)->fetch();
                        }
                        catch (FluentPdoException $e)
                        {
                        }
                        if ($result)
                        {
                            $this->addErrorForRule($attr, self::RULE_UNIQUE, $rule);
                        }
                    }
                    if($ruleName == self::RULE_WORK_DAY)
                    {
                        if (!is_null($value))
                        {
                            $date = new DateTime($value);
                            if ($date->format('N') > 5)
                            {
                                $this->addErrorForRule($attr, self::RULE_WORK_DAY);
                            }
                        }
                    }
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Returns predetermined messaged to display for each error.
     *
     * @return string[]
     */
    public function getErrorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Este campo es requerido',
            self::RULE_REQUIRED_WHEN => 'Este campo es requerido',
            self::RULE_EMAIL => 'Este campo debe ser un correo electronico valido',
            self::RULE_CEDULA => 'Este campo debe ser una cedula valida',
            self::RULE_MIN => 'El campo debe tener minimo {min} caracteres',
            self::RULE_MAX => 'El campo debe tener maximo {max} caracteres',
            self::RULE_PASSWORD_MATCH => 'Las contraseñas no coinciden',
            self::RULE_UNIQUE => 'Ya existe una cuenta con est{field}',
            self::RULE_WORK_DAY => 'La fecha no puede ser Sabado o Domingo'
        ];
    }

    /**
     * Adds a personalized error message
     *
     * @param string $attribute
     * @param string $message
     */
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    /**
     * Adds an error for a specific rule
     *
     * @param string $attribute
     * @param string $rule
     * @param array $params
     */
    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        $message = $this->getErrorMessages()[$rule] ?? '';

        foreach ($params as $key => $value)
        {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function hasError($attribute): bool
    {
        if ($this->errors[$attribute] ?? false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function getFirstError($attribute): mixed
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? null;
    }

    /**
     * @return \Shield1739\UTP\CitasCss\app\PDOUtils
     */
    public function getPdoUtils(): PDOUtils
    {
        return $this->pdoUtils;
    }

}