<?php

namespace JsonSerializablePhp;

abstract class JsonSerializable implements \JsonSerializable
{
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
                $arguments = \array_merge(
                    [
                        'fieldName' => null,
                        'includeIfNull' => true,
                        'ignore' => false,
                    ],
                    $attributes[0]->getArguments(),
                );
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
}