<?php

namespace Shield1739\UTP\CitasCss\core\forms;

use JetBrains\PhpStorm\Pure;

class FloatingInputField extends InputField
{
    protected string $label;

    #[Pure] public function __construct(string $varName, ?string $value, string $label)
    {
        parent::__construct($varName, $value);
        $this->label = $label;
    }

    private function renderLabel(): string
    {
        return sprintf('
            <label for="%s">%s</label>',
            $this->varName,
            $this->label
        );
    }

    #[Pure] public function __toString(): string
    {
        return sprintf('
            <div class="form-floating form-floating-group flex-grow-1">
            %s
            %s
            </div>
            %s',
            $this->renderInput(),
            $this->renderLabel(),
            $this->renderInvalid()
        );
    }
}