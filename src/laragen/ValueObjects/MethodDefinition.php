<?php

namespace Mwl91\Laragen\ValueObjects;

use ReflectionMethod;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;

class MethodDefinition
{
    private string $name;
    private bool $isStatic;
    private bool $isFinal;
    private string $visibility;
    private array $parameters;
    private ?string $response;
    private bool $responseNullable;
    private string $body;

    public function __construct(
        string $name,
        string $visibility = ClassType::VISIBILITY_PUBLIC,
        bool $isStatic = false,
        bool $isFinal = false
    ) {
        $this->name = $name;
        $this->parameters = [];
        $this->response = null;
        $this->responseNullable = false;
        $this->body = 'return;';
        $this->visibility = $visibility;
        $this->isStatic = $isStatic;
        $this->isFinal = $isFinal;
    }

    public static function instantiateFromExisting(string $className, string $methodName): self
    {
        $reflectionMethod = new ReflectionMethod($className, $methodName);

        if ($reflectionMethod->isPublic()) {
            $visibility = ClassType::VISIBILITY_PUBLIC;
        } else if ($reflectionMethod->isPrivate()) {
            $visibility = ClassType::VISIBILITY_PRIVATE;
        } else if ($reflectionMethod->isProtected()) {
            $visibility = ClassType::VISIBILITY_PROTECTED;
        }

        $definition = new self(
            $reflectionMethod->getName(),
            $visibility,
            $reflectionMethod->isStatic(),
            $reflectionMethod->isFinal()
        );

        foreach ($reflectionMethod->getParameters() as $parameter) {
            $defaultValue = null;
            if ($parameter->isDefaultValueAvailable()) {
                $defaultValue = $parameter->getDefaultValue();
            }

            $definition->parameters[] = new MethodParameter(
                $parameter->getType()->getName(),
                $parameter->name,
                $parameter->getType()->allowsNull(),
                $defaultValue
            );
        }

        $definition->response = optional($reflectionMethod->getReturnType())->getName();
        if (optional($reflectionMethod->getReturnType())->allowsNull()) {
            $definition->response = $reflectionMethod->getReturnType()->getName();
            $definition->setResponseNullable(true);
        }

        $lines = array_slice(
            file($reflectionMethod->getFileName()),
            $reflectionMethod->getStartLine(),
            $reflectionMethod->getEndLine() - $reflectionMethod->getStartLine()
        );

        $lines[0] = Str::after($lines[0], '{');
        $lines[count($lines) - 1] = Str::beforeLast($lines[count($lines) - 1], '}');

        $body = implode(" ", $lines);
        $definition->setBody($body);

        return $definition;
    }

    public function setParameter(MethodParameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
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

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function isStatic(): bool
    {
        return $this->isStatic;
    }

    public function isFinal(): bool
    {
        return $this->isFinal;
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
