<?php

namespace JsonSerializablePhp;

#[\Attribute]
class JsonField
{
    public function __construct(
        private ?string $fieldName = null,
        private bool $includeIfNull = true,
        private bool $ignore = false,
    ) {
    }
}