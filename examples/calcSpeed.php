<?php

require_once __DIR__ . '/../vendor/autoload.php';

const REPEAT_TIMES = 1e4;

use JsonSerializablePhp\JsonSerializable;
use JsonSerializablePhp\JsonField;

function timeFunction(callable $callable, string $name)
{
    $begin = microtime(true);
    for ($i = 0; $i < REPEAT_TIMES; $i++)
        $callable();
    $end = microtime(true);
    $timeMs = ($end - $begin) * 1000;
    $eachMs = $timeMs / REPEAT_TIMES;
    echo "$name took {$timeMs}ms, each execution took {$eachMs}ms on average" . PHP_EOL;
    return $timeMs;
}

/**
 * @param list<array{0: callable, 1: string}> ...$objs
 * @return void
 */
function timeFunctions(array ...$objs) {
    $times = [];
    /** @var string[] $names */
    $names = array_map(fn($obj) => $obj[1], $objs);
    foreach($objs as $obj) {
        $times[] = timeFunction(...$obj);
    }
    echo PHP_EOL . PHP_EOL;
    $timesCombined = array_map(null, $names, $times);

    usort($timesCombined,  fn ($a, $b) => $a[1] <=> $b[1]);

    function compare($prevName, $prevTime, $name, $time) {
        // prevTime is by definition faster than time
        $timesFaster = round(($time / $prevTime) - 1, 3);;

        echo "$prevName is ~{$timesFaster}x faster than $name" . PHP_EOL;
    }

    /** @var ?array{0: string, 1: float} $prevTime */
    $prevValue = null;
    foreach($timesCombined as $value) {
        if ($prevValue === null) {
            $prevValue = $value;
            continue;
        }
        compare (...$prevValue, ...$value);


        $prevValue = $value;
    }

    echo PHP_EOL;
    compare(...$timesCombined[0], ...$timesCombined[count($timesCombined) - 1]);

}


class MySerializableClass extends JsonSerializable {
    private string $myField1 = 'myValue1';

    #[JsonField(fieldName: 'anotherName')]
    private string $myCustomField = 'myValue2';

    private string $myCustomField2 = 'myValue2';
    private string $myCustomField3 = 'myValue3';
    private string $myCustomField4 = 'myValue4';
    private string $myCustomField5 = 'myValue5';
    private string $myCustomField6 = 'myValue6';
    private string $myCustomField7 = 'myValue7';
    private string $myCustomField8 = 'myValue8';
    private string $myCustomField9 = 'myValue9';
    private string $myCustomField10 = 'myValue10';
    private string $myCustomField11 = 'myValue11';

    #[JsonField(ignore: true)]
    private string $myIgnoredField = 'ignored';
}

class MyClassicSerializableClass implements \JsonSerializable
{
    private string $myField1 = 'myValue1';

    private string $myCustomField = 'myValue2';
    private string $myCustomField2 = 'myValue2';
    private string $myCustomField3 = 'myValue2';
    private string $myCustomField4 = 'myValue2';
    private string $myCustomField5 = 'myValue2';
    private string $myCustomField6 = 'myValue2';
    private string $myCustomField7 = 'myValue2';
    private string $myCustomField8 = 'myValue2';
    private string $myCustomField9 = 'myValue2';
    private string $myCustomField10 = 'myValue2';
    private string $myCustomField11 = 'myValue2';

    private string $myIgnoredField = 'ignored';

    public function jsonSerialize(): array
    {
        return [
            'myField1' => $this->myField1,
            'anotherName' => $this->myCustomField,
            'myCustomField2' => $this->myCustomField2,
            'myCustomField3' => $this->myCustomField3,
            'myCustomField4' => $this->myCustomField4,
            'myCustomField5' => $this->myCustomField5,
            'myCustomField6' => $this->myCustomField6,
            'myCustomField7' => $this->myCustomField7,
            'myCustomField8' => $this->myCustomField8,
            'myCustomField9' => $this->myCustomField9,
            'myCustomField10' => $this->myCustomField10,
            'myCustomField11' => $this->myCustomField11,
        ];
    }
}

class ManyAttributesSerializableClass extends JsonSerializable {
    #[JsonField]
    private string $myField1 = 'myValue1';

    #[JsonField(fieldName: 'anotherName')]
    private string $myCustomField = 'myValue2';

    #[JsonField]
    private string $myCustomField2 = 'myValue2';
    #[JsonField]
    private string $myCustomField3 = 'myValue3';
    #[JsonField]
    private string $myCustomField4 = 'myValue4';
    #[JsonField]
    private string $myCustomField5 = 'myValue5';
    #[JsonField]
    private string $myCustomField6 = 'myValue6';
    #[JsonField]
    private string $myCustomField7 = 'myValue7';
    #[JsonField]
    private string $myCustomField8 = 'myValue8';
    #[JsonField]
    private string $myCustomField9 = 'myValue9';
    #[JsonField]
    private string $myCustomField10 = 'myValue10';
    #[JsonField]
    private string $myCustomField11 = 'myValue11';

    #[JsonField(ignore: true)]
    private string $myIgnoredField = 'ignored';
}


class ManyNonEmptyAttributesSerializableClass extends JsonSerializable {
    #[JsonField]
    private string $myField1 = 'myValue1';

    #[JsonField(fieldName: 'anotherName')]
    private string $myCustomField = 'myValue2';

    #[JsonField(fieldName: 'anotherName2')]
    private string $myCustomField2 = 'myValue2';
    #[JsonField(fieldName: 'anotherName3')]
    private string $myCustomField3 = 'myValue3';
    #[JsonField(fieldName: 'anotherName4')]
    private string $myCustomField4 = 'myValue4';
    #[JsonField(fieldName: 'anotherName5')]
    private string $myCustomField5 = 'myValue5';
    #[JsonField(fieldName: 'anotherName6')]
    private string $myCustomField6 = 'myValue6';
    #[JsonField(fieldName: 'anotherName7')]
    private string $myCustomField7 = 'myValue7';
    #[JsonField(fieldName: 'anotherName8')]
    private string $myCustomField8 = 'myValue8';
    #[JsonField(fieldName: 'anotherName9')]
    private string $myCustomField9 = 'myValue9';
    #[JsonField(fieldName: 'anotherName10')]
    private string $myCustomField10 = 'myValue10';
    #[JsonField(fieldName: 'anotherName11')]
    private string $myCustomField11 = 'myValue11';

    #[JsonField(ignore: true)]
    private string $myIgnoredField = 'ignored';
}

timeFunctions(
    [
        static function() {
            $class = new MySerializableClass;
            json_encode($class);
        },
        "Reflection"
    ],

    [
        static function() {
            $class = new ManyAttributesSerializableClass();
            json_encode($class);
        },
        "Reflection: Many attributes"
    ],

    [
        static function() {
            $class = new ManyNonEmptyAttributesSerializableClass();
            json_encode($class);
        },
        "Reflection: Many non-empty attributes"
    ],

    [
        static function() {
            $class = new MyClassicSerializableClass;
            json_encode($class);
        },
        'Classic'
    ]
);