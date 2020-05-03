<?php

namespace Mwl91\Laragen\ValueObjects;

class MethodParameter
{
    private string $name;
    private ?string $type;
    private bool $nullable;
    private $defaultValue;

    public function __construct(?string $type, string $name, bool $nullable = false, $defaultValue = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->nullable = $nullable;
        $this->defaultValue = $defaultValue;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNullable(): bool
    {
        return $this->nullable;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}
