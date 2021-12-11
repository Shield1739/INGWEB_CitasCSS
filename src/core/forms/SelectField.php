<?php

namespace Shield1739\UTP\CitasCss\core\forms;

use JetBrains\PhpStorm\Pure;

class SelectField extends Field
{
    protected array $options;
    protected ?int $selectedID;
    protected bool $liveSearch;

    #[Pure] public function __construct(string $varName, array $options, ?int $selectedID)
    {
        parent::__construct($varName);
        $this->options = $options;
        $this->selectedID = $selectedID;
        $this->liveSearch = false;
    }

    private function buildOptions(): string
    {
        $builtOptions = '';

        foreach ($this->options as $id => $name)
        {
            $builtOptions = sprintf('
                %s
                <option %s value="%s" %s>%s</option>',
                $builtOptions,
                $this->selectedID === $id ? 'selected' : '',
                $id,
                is_array($name) ? 'data-subtext="'.$name[1].'"' : '',
                is_array($name) ? $name[0] : $name,
            );
        }

        return $builtOptions;
    }

    public function __toString(): string
    {
        return sprintf('
            <select id="%sSelect" name="%s" class="selectpicker form-control %s" data-live-search="%s" title="Seleccione una opcion" %s %s %s>
            %s
            </select>
            %s',
            $this->idPrefix ? $this->varName . $this->idPrefix : $this->varName,
            $this->varName,
            $this->error ? 'is-invalid' : '',
            $this->liveSearch,
            $this->autoSubmit ? 'onchange="hiddenSubmit(\''.$this->varName.'\');"' : '',
            $this->onChange ? 'onchange="'.$this->onChange.'"' : '',
            $this->disabled ? 'disabled' : '',
            $this->buildOptions(),
            $this->renderInvalid()
        );
    }

    /**
     * @param bool $liveSearch
     */
    public function setLiveSearch(bool $liveSearch): void
    {
        $this->liveSearch = $liveSearch;
    }

}