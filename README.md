# json_serializable.php

An easier (and experimental) way to serialize PHP classes into JSON.

Please note that this library was made more for learning than to be actually used, and this would be way slower than just defining the value array yourself (since it makes use of reflection).

TL;DR: don't use this.

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