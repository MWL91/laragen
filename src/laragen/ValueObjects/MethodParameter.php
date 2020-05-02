<?php

namespace Mwl91\Laragen\ValueObjects;

class MethodParameter
{
    private ?string $type;
    private string $name;
    private bool $nullable;

    public function __construct(?string $type, string $name, bool $nullable = false)
    {
        $this->type = $type;
        $this->name = $name;
        $this->nullable = $nullable;
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
}
