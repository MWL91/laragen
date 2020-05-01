<?php

namespace Mwl91\Laragen\Commands;

use Illuminate\Console\Command;
use Mwl91\Laragen\ValueObjects\MethodParameter;
use Mwl91\Laragen\ValueObjects\MethodDefinition;

abstract class InputMethodDefinitionCommand extends Command
{

    const ASK_ADD_METHOD = 'Set new method name or press enter to exit';
    const ASK_ADD_PARAMETER_TYPE = 'Set type of parameter or press enter to exit';
    const ASK_ADD_PARAMETER_NAME = 'Set parameter name';
    const ASK_SET_RESPONSE_TYPE = 'Set response type method';
    const ASK_SET_RESPONSE_NULLABLE = 'Type `?` if response may be nullable';
    const ASK_CONFIRM_EXIT = 'Press enter again to confirm';
    const INFO_NEW_METHOD = 'OK - let\'s create a new method';
    const INFO_PARAMETERS_SETED = 'OK - your parameters are set';
    const INVALID_METHOD_EXCEPTION = 'Parameter must have type and name after space - ex. int number or ExampleClass example';

    private array $methods = [];

    protected function getMethodsDefinitionInput(): array
    {
        while (true) {
            $this->comment(self::INFO_NEW_METHOD);
            $method = $this->ask(self::ASK_ADD_METHOD);

            if (is_null($method)) {
                if (!$this->ask(self::ASK_CONFIRM_EXIT)) {
                    break;
                } else {
                    continue;
                }
            }

            $this->methods[] = $this->getMethodDefinition($method);
        }

        return $this->methods;
    }

    private function getMethodDefinition(string $method): MethodDefinition
    {
        $methodDefinition = new MethodDefinition($method);
        $this->getParametersInput($methodDefinition);

        $this->comment(self::INFO_PARAMETERS_SETED);

        $response = $this->ask(self::ASK_SET_RESPONSE_TYPE);
        if ($response) {
            $methodDefinition->setResponse($response);
            $methodDefinition->setResponseNullable($this->ask(self::ASK_SET_RESPONSE_NULLABLE) == '?');
        }

        return $methodDefinition;
    }

    private function getParametersInput(MethodDefinition &$methodDefinition): void
    {
        while (true) {
            $parameterType = $this->ask(self::ASK_ADD_PARAMETER_TYPE);
            if (is_null($parameterType)) {
                if (!$this->ask(self::ASK_CONFIRM_EXIT)) {
                    break;
                } else {
                    continue;
                }
            }

            $parameterName = $this->ask(self::ASK_ADD_PARAMETER_NAME);
            $methodDefinition->setParameter(new MethodParameter($parameterType, $parameterName));
        }
    }
}
