<?php

namespace Mwl91\Laragen\ValueObjects;

class MethodDefinition
{
    private string $name;
    private array $parameters;
    private ?string $response;
    private bool $responseNullable;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->parameters = [];
        $this->responseNullable = false;
    }

    public function setParameter(MethodParameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }

    public function setResponse(string $response): void
    {
        $this->response = $response;
    }

    public function setResponseNullable(bool $responseNullable): void
    {
        $this->responseNullable = $responseNullable;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function getResponseNullable(): bool
    {
        return $this->responseNullable;
    }
}
