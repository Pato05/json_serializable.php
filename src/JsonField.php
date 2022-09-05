<?php

namespace JsonSerializablePhp;

#[\Attribute]
class JsonField
{
    public function __construct(
        ?string $fieldName = null,
        bool $includeIfNull = true,
        bool $ignore = false,
    ) {
    }
}