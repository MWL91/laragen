<?php

namespace Mwl91\Laragen\ValueObjects;

use ReflectionMethod;

class MethodDefinition
{
    private string $name;
    private array $parameters;
    private ?string $response;
    private bool $responseNullable;
    private string $body;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->parameters = [];
        $this->responseNullable = false;
        $this->body = 'return;';
    }

    /**
     * @param string $className
     * @param string $methodName
     * @return self
     */
    final public static function instantiateFromExisting(string $className, string $methodName): self
    {
        $reflectionMethod = new ReflectionMethod($className, $methodName);

        $definition = new self($reflectionMethod->getName());

        foreach ($reflectionMethod->getParameters() as $parameter) {
            $definition->parameters[] = new MethodParameter($parameter->getType()->getName(), $parameter->name, $parameter->getType()->allowsNull());
        }

        $definition->response = $reflectionMethod->getReturnType()->getName();
        if ($reflectionMethod->getReturnType()->allowsNull()) {
            $definition->response = '?' . $reflectionMethod->getReturnType()->getName();
        }

        $definition->setBody(
            implode(
                " ",
                array_slice(
                    file($reflectionMethod->getFileName()),
                    $reflectionMethod->getStartLine(),
                    $reflectionMethod->getEndLine() - $reflectionMethod->getStartLine()
                )
            )
        );

        return $definition;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
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

    public function getBody(): string
    {
        return $this->body;
    }
}
