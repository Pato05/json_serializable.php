# json_serializable.php

An easier (and experimental) way to serialize PHP classes into JSON.

Please note that this library was made more for learning than to be actually used, and this would be way slower than just defining the value array yourself (since it makes use of reflection).

TL;DR: don't use this if you care about speed.

## Usage

```php
<?php

use JsonSerializablePhp\JsonSerializable;
use JsonSerializablePhp\JsonField;

class MySerializableClass extends JsonSerializable {
    private string $myField1 = 'myValue1';
    
    #[JsonField(fieldName: 'anotherName')]
    private string $myCustomField = 'myValue2';
    
    #[JsonField(ignore: true)]
    private string $myIgnoredField = 'ignored';
}

$instance = new MySerializableClass;
echo json_encode($instance);
```

## But how does it work?

You may have noticed that this library requires PHP >= 8.1, because it makes use of PHP Attributes together with reflection to achieve this result.

You can see the inner workings by checking out [`src/JsonSerializable.php`](https://github.com/Pato05/json_serializable.php/blob/main/src/JsonSerializable.php)

## How slower is this?

By tests (as defined in [`examples/calcSpeed.php`](https://github.com/Pato05/json_serializable.php/blob/main/examples/calcSpeed.php)), it seems that the reflection approach is about 4 to 5 times slower than defining the array by yourself.
This gets worse if you use a JsonField attribute on your values.

Speed test result on my machine:

```
Classic is ~3.799x faster than Reflection
Reflection is ~0.338x faster than Reflection: Many attributes
Reflection: Many attributes is ~0.068x faster than Reflection: Many non-empty attributes

Classic is ~5.857x faster than Reflection: Many non-empty attributes
```

TL;DR this should be fine to use in small classes, but expect it to be pretty slow in big ones (speed changes based on class attributes).