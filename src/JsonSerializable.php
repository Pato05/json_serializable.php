<?php

namespace JsonSerializablePhp;

abstract class JsonSerializable implements \JsonSerializable
{
    /**
     * @throws \ReflectionException
     */
    public function jsonSerialize(): array
    {
        // Use reflection to get fields and attributes
        $reflection = new \ReflectionClass($this);
        $serializedArray = [];
        $props = $reflection->getProperties();
        foreach($props as $prop) {
            $attributes = $prop->getAttributes(JsonField::class);
            $prop->setAccessible(true);
            $value = $prop->getValue($this);
            // only read first attribute
            if (isset($attributes[0])) {
                $instance = $attributes[0]->newInstance();
                $class = new \ReflectionClass($instance);
                $arguments = $this->propsAsArray($class->getProperties(), $instance);
                \assert(isset($arguments['fieldName']));
                \assert(isset($arguments['includeIfNull']));
                \assert(isset($arguments['ignore']));
                if ($arguments['ignore'] === true) continue;
                if ($arguments['includeIfNull'] === false && $value === null) continue;
                /** @var string|null $fieldName */
                $fieldName = $arguments['fieldName'];
                if ($fieldName !== null) {
                    $serializedArray[$fieldName] = $value;
                    continue;
                }
            }
            $serializedArray[$prop->getName()] = $value;
        }

        return $serializedArray;
    }

    /**
     * @param \ReflectionProperty[] $properties
     * @return array<string, mixed>
     */
    private function propsAsArray(array $properties, mixed $instance): array {
        $arr =  [];
        foreach ($properties as $prop) {
            $prop->setAccessible(true);
            $arr[$prop->getName()] = $prop->getValue($instance);
        }

        return $arr;
    }
}