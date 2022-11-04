<?php

namespace App\Classes\Abstracts;

use App\Classes\Interfaces\IFieldValidator;

abstract class BaseField implements IFieldValidator
{
    public string $name;
    public bool $required = false;
    public bool $nullable = false;
    private array $additionalRules = [];

    /**
     * @param $args
     */
    public function __construct($args)
    {
        foreach ($args as $field => $value) {
            if (!empty($value)) $this->{$field} = $value;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @param $required
     * @param bool|null $nullable
     * @param array|null $rules
     * @return static
     */
    public static function options(
        string $name = null,
        $required = null,
        bool $nullable = null,
        array $rules = null
    ): static
    {
        $args = get_defined_vars();
        return new static($args);
    }

    /**
     * @param $rule
     * @return $this
     */
    public function addRule($rule)
    {
        $this->additionalRules[] = $rule;
        return $this;
    }

    /**
     * @return array
     */
    public function getAdditionalRules(): array
    {
        return $this->additionalRules;
    }
}
