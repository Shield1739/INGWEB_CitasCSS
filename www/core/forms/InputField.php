<?php

namespace Shield1739\UTP\CitasCss\core\forms;

use JetBrains\PhpStorm\Pure;

abstract class InputField extends Field
{
    protected const TYPE_TEXT = 'text';
    protected const TYPE_PASSWORD = 'password';
    protected const TYPE_DATE = 'date';

    protected ?string $value;
    protected string $type;
    protected ?string $min;
    protected ?string $max;

    #[Pure] public function __construct(string $varName, ?string $value)
    {
        parent::__construct($varName);
        $this->value = $value;
        $this->type = self::TYPE_TEXT;
        $this->min = null;
        $this->max = null;
    }

    public function renderInput(): string
    {
        return sprintf('
            <input id="%sInput" name="%s" value="%s" type="%s" class="form-control %s" placeholder="" %s %s %s %s %s %s %s>',
            $this->idPrefix ? $this->varName . $this->idPrefix : $this->varName,
            $this->varName,
            $this->value,
            $this->type,
            $this->error ? 'is-invalid' : '',
            $this->min ? 'min="'.$this->min.'"' : '',
            $this->max ? 'max="'.$this->max.'"' : '',
            $this->autoSubmit ? 'onchange="hiddenSubmit(\''.$this->varName.'\');"' : '',
            $this->onChange ? 'onchange="'.$this->onChange.'"' : '',
            $this->disabled ? 'disabled' : '',
            $this->readOnly ? 'readonly' : '',
            $this->hidden ? 'hidden' : ''
        );
    }

    /**
     * @param string|null $value
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function setFieldTypePassword()
    {
        $this->type = self::TYPE_PASSWORD;
    }

    public function setFieldTypeDate()
    {
        $this->type = self::TYPE_DATE;
    }

    /**
     * @param string|null $min
     */
    public function setMin(?string $min): void
    {
        $this->min = $min;
    }

    /**
     * @param string|null $max
     */
    public function setMax(?string $max): void
    {
        $this->max = $max;
    }
}