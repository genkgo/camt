<?php

declare(strict_types=1);

namespace Genkgo\TestCamt\Unit;

use DateTimeImmutable;
use DateTimeZone;
use Money\Money;
use ReflectionClass;
use ReflectionMethod;

class Dumper
{
    private array $saw = [];

    public function dump(object|array|string|float|int|bool|null $variable): string
    {
        $this->saw = [];
        $a = $this->cast($variable);

        return json_encode($a, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }

    private function cast(object|array|string|float|int|bool|null $variable): array|string|float|int|bool|null
    {
        if ((is_iterable($variable))) {
            $values = [];
            foreach ($variable as $k => $v) {
                $values[$k] = $this->cast($v);
            }

            return $values;
        }

        if ($variable instanceof DateTimeImmutable) {
            return [
                '__CLASS__' => $variable::class,
                $variable->setTimezone(new DateTimeZone('UTC'))->format('c'),
            ];
        }

        if (is_object($variable)) {
            $properties = $this->castObject($variable);

            return $this->cast($properties);
        }

        return $variable;
    }

    private function castObject(object $object): array|string
    {
        $key = spl_object_id($object);
        if (array_key_exists($key, $this->saw)) {
            return '__RECURSIVITY__';
        }
        $this->saw[$key] = $object;

        $values = $this->getGetterValues($object);
        ksort($values);

        $values = array_merge(['__CLASS__' => $object::class], $values);

        return $values;
    }

    private function getGetterValues(object $object): array
    {
        $class = new ReflectionClass($object);

        $values = [];
        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $name = $method->getName();
            if (str_starts_with($name, 'get')
                && ($class->getName() !== Money::class || in_array($name, ['getAmount', 'getCurrency'], true))
            ) {
                $values[$name] = $method->invoke($object);
            }
        }

        return $values;
    }
}
