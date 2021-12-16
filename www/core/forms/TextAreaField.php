<?php

namespace Shield1739\UTP\CitasCss\core\forms;

use JetBrains\PhpStorm\Pure;

class TextAreaField extends Field
{
    protected ?string $value;

    #[Pure] public function __construct(string $varName, ?string $value)
    {
        parent::__construct($varName);
        $this->value = $value;
    }

    public function renderInput(): string
    {
        return sprintf('
            <textarea class="form-control %s" name="%s" %s>%s</textarea>',
            $this->error ? 'is-invalid' : '',
            $this->varName,
            $this->readOnly ? 'readonly' : '' ,
            $this->value
        );

    }

    #[Pure] public function __toString(): string
    {
        return sprintf('
            %s
            %s',
            $this->renderInput(),
            $this->renderInvalid()
        );
    }
}