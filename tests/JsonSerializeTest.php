<?php


use PHPUnit\Framework\TestCase;

use JsonSerializablePhp\JsonSerializable;
use JsonSerializablePhp\JsonField;

class SerializableTest extends JsonSerializable
{
    #[JsonField(fieldName: 'myNameIsDifferent')]
    private string $differentlyNamedField = 'hello';

    private string $sameNameField = 'testing123';

    #[JsonField(ignore: true)]
    private string $iWontBeSerialized = 'not_serialized';

    private ?string $myNullableField = null;

    #[JsonField(includeIfNull: false)]
    private ?string $myNonIncludedNullableField = null;
}

final class JsonSerializeTest extends TestCase
{
    public function testSerializeClass(): void
    {
        $serializable = new SerializableTest;
        $array = $serializable->jsonSerialize();
        $this->assertEqualsCanonicalizing([
            'myNameIsDifferent' => 'hello',
            'sameNameField' => 'testing123',
            'myNullableField' => null,
        ], $array);
    }

    public function testAnonymousClass(): void
    {
        $serializable = new class extends JsonSerializable {
            #[JsonField(fieldName: 'myNameIsDifferent')]
            private string $differentlyNamedField = 'hello';

            private string $sameNameField = 'testing123';

            #[JsonField(ignore: true)]
            private string $iWontBeSerialized = 'not_serialized';
        };

        $array = $serializable->jsonSerialize();
        $this->assertEqualsCanonicalizing([
            'myNameIsDifferent' => 'hello',
            'sameNameField' => 'testing123',
        ], $array);
    }
}
