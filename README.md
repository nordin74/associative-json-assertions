# JSON - Associaive Array assertions for PHPUnit

[![Latest Stable Version](https://img.shields.io/packagist/v/nordin74/associative-json-assertions.svg)](https://packagist.org/packages/nordin74/associative-json-assertions)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net/)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c28e191f9dd543949859a8d91d3c12bb)](https://app.codacy.com/app/nordin74/associative-json-assertions?utm_source=github.com&utm_medium=referral&utm_content=nordin74/associative-json-assertions&utm_campaign=badger)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/a8bf0fc9e202430787bfef82204dfd38)](https://www.codacy.com/app/nordin74/associative-json-assertions?utm_source=github.com&utm_medium=referral&utm_content=nordin74/associative-json-assertions&utm_campaign=Badge_Coverage)
[![Build Status](https://travis-ci.org/nordin74/associative-json-assertions.svg?branch=master)](https://travis-ci.org/nordin74/associative-json-assertions)

The intentions of this library is provide easy/intuitive assertions when we are a dealing with nested associative     
arrays or JSON responses. It based on [PHPUnit](https://phpunit.de/)


## Installation

    $ composer require --dev nordin74/associative-json-assertions


## Usage

Add the trait `use AssociativeAssertions\AssociativeArrayTrait` or extend the class `AbstractAssociativeArray` and 
use the defined assertions `AssociativeAssertions\AssociativeAssertions` in your test case 


```php
<?php

use PHPUnit\Framework\TestCase;
use AssociativeAssertions\AssociativeArrayTrait;
use AssociativeAssertions\AssociativeAssertions as AA;

class MyTestCase extends TestCase
{
    use AssociativeArrayTrait;

    public function testSuccessfulJSONResponse()
        {
            $json =
                    '{
                        "id"       : 11,
                        "extId"    : "111",
                        "isActive" : true,
                        "value"    : 12,
                        "firstname": "Seiya",
                        "surname"  : "unknown",
                        "height"   : 1.70,
                        "cloth"    : "Pegasus",
                        "deeper"   : {
                            "key1": "val1",
                            "key2": "2018-02-28 11:11:11",
                            "key3": ["val1", "val2", 11]
                        }
                     }';
    
            $expected = [
                'id'        => AA::assertInt(),
                'extId'     => AA::assertDigit(),
                'isActive'  => AA::assertBoolean(),
                'value'     => 12,
                'firstname' => 'Seiya',
                'surname'   => AA::assertRegExp('~\w+known~'),
                'height'    => AA::assertFloat(),
                'cloth'     => AA::assertScalar(),
                'deeper'    => [
                    'key1' => 'val1',
                    'key2' => AA::assertDateTimeStr('Y-m-d H:i:s'),
                    'key3' => function () {
                        $actual = func_get_args()[0];
                        $this::assertCount(3, $actual);
                    }
                ]
            ];
    
            $this->assertAssociativeArray($expected, json_decode($json, true));
        }
}
```

You can define your own assertions. Example: 
```php
<?php
    [
        'key' => function () {
            $valueForBeingTested = func_get_args()[0];
            // Some awesome assertion
        }
    ];
```
If the assertion logic is complex you can also extend the class `AssociativeAssertions`.


## Copyright

This library is [MIT-licensed](LICENSE.txt).