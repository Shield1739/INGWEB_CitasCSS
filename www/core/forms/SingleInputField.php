<?php

namespace Shield1739\UTP\CitasCss\core\forms;

use JetBrains\PhpStorm\Pure;

class SingleInputField extends InputField
{
    #[Pure] public function __toString(): string
    {
        return sprintf('
            %s
            %s
            ',
            $this->renderInput(),
            $this->renderInvalid()
        );
    }
}