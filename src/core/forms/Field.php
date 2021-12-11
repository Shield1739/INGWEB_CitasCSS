<?php

namespace Shield1739\UTP\CitasCss\core\forms;

abstract class Field
{
    protected string $varName;
    protected bool $autoSubmit;
    protected ?string $error;
    protected bool $readOnly;
    protected bool $disabled;
    protected bool $hidden;
    protected ?string $idPrefix;
    protected ?string $onChange;

    /**
     * @param string $varName
     */
    public function __construct(string $varName)
    {
        $this->varName = $varName;
        $this->autoSubmit = false;
        $this->error = null;
        $this->readOnly = false;
        $this->disabled = false;
        $this->hidden = false;
        $this->idPrefix = null;
        $this->onChange = null;
    }

    protected function renderInvalid(): string
    {
        return sprintf('
            <div class="invalid-feedback%s">%s</div>',
            empty($this->error) ? '' : ' d-block',
            $this->error
        );
    }

    /**
     * @param bool $autoSubmit
     */
    public function setAutoSubmit(bool $autoSubmit): void
    {
        $this->autoSubmit = $autoSubmit;
    }

    /**
     * @param string|null $error
     */
    public function setError(?string $error): void
    {
        $this->error = $error;
    }

    /**
     * @param bool $readOnly
     */
    public function setReadOnly(bool $readOnly): void
    {
        $this->readOnly = $readOnly;
    }

    /**
     * @param bool $disabled
     */
    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * @param string|null $idPrefix
     */
    public function setIdPrefix(?string $idPrefix): void
    {
        $this->idPrefix = $idPrefix;
    }

    /**
     * @param string|null $onChange
     */
    public function setOnChange(?string $onChange): void
    {
        $this->onChange = $onChange;
    }

}