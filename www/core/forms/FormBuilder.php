<?php

namespace Shield1739\UTP\CitasCss\core\forms;

use Shield1739\UTP\CitasCss\core\common\Entity;
use Shield1739\UTP\CitasCss\core\common\Model;

class FormBuilder
{
    public Model $model;
    protected array $entities = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function addEntity(string $key, Entity $entity)
    {
        $this->entities[$key] = $entity;
    }

    private function getValueFromAttribute(?string $entityKey, string $attribute)
    {
        return $entityKey ? $this->entities[$entityKey]->{$attribute} : $this->model->{$attribute};
    }

    public function renderFloatingInputField(string $attribute, string $label, ?string $entityKey = null): FloatingInputField
    {
        $field = new FloatingInputField($attribute, $this->getValueFromAttribute($entityKey, $attribute), $label);

        $firstError = $this->model->getFirstError($attribute);
        if ($firstError)
        {
            $field->setError($firstError);
        }

        return $field;
    }

    public function renderSingleInputField(string $attribute, ?string $entityKey = null): SingleInputField
    {
        $field = new SingleInputField($attribute, $this->getValueFromAttribute($entityKey, $attribute));

        $firstError = $this->model->getFirstError($attribute);
        if ($firstError)
        {
            $field->setError($firstError);
        }

        return $field;
    }

    public function renderSelectField(string $attribute, array $options = [], ?string $entityKey = null): SelectField
    {
        $select = new SelectField($attribute, $options, $this->getValueFromAttribute($entityKey, $attribute));
        $firstError = $this->model->getFirstError($attribute);
        if ($firstError)
        {
            $select->setError($firstError);
        }

        return $select;
    }

    public function renderTextAreaField( string $attribute, ?string $entityKey = null): TextAreaField
    {
        return new TextAreaField($attribute, $this->getValueFromAttribute($entityKey, $attribute));
    }
}