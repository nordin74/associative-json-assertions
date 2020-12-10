<?php

namespace AssociativeAssertions\Tests;

use AssociativeAssertions\AssociativeArrayTrait;
use AssociativeAssertions\AssociativeAssertions as AA;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class AssociativeArrayTest extends TestCase
{
    use AssociativeArrayTrait;


    public function testSuccessfulAssertDateTimeStr()
    {
        $this->assertDateTimeStr('Y-m-d H:i:s', date('Y-m-d H:i:s'));
    }


    public function testSuccessfulAssertDigit()
    {
        $this->assertDigit('11');
    }


    public function testSuccessfulJSONResponse()
    {
        $json =
            <<<JSON
        {
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
        }
JSON;

        $expected = [
            'id'        => AA::assertInt(),
            'extId'     => AA::assertDigit(),
            'isActive'  => AA::assertBoolean(),
            'value'     => 12,
            'firstname' => AA::assertString(),
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


    public function testFailKeysDiffer()
    {
        $actual = [
            'id'    => 11,
            'extId' => '111',
            'date'  => new \DateTime()
        ];

        $expected = [
            'id'        => 11,
            'value'     => 12,
            'firstname' => 'Seiya'
        ];

        $message = '';
        try {
            $this->assertAssociativeArray($expected, $actual);
        } catch (ExpectationFailedException $exception) {
            $message = $exception->getMessage();
        }

        $this->assertEquals('Failed asserting that two arrays are identical.', $message);
    }


    public function testFailExactMatch()
    {
        $actual = [
            'firstname' => 'Seiya',
            'deeper'    => [
                'key1' => 'val1',
                'key2' => '2018-02-28 11:11:11',
                'key3' => function () {
                    return time();
                }
            ]
        ];

        $expected = [
            'firstname' => 'Seiya',
            'deeper'    => [
                'key1' => 'val2',
                'key2' => AA::assertDateTimeStr('Y-m-d H:i:s'),
                'key3' => AA::assertCallable()
            ]
        ];

        $message = '';
        try {
            $this->assertAssociativeArray($expected, $actual);
        } catch (ExpectationFailedException $exception) {
            $message = $exception->getComparisonFailure()->toString();
        }

        $this->assertEquals(
            <<<EOF

--- Expected
+++ Actual
@@ @@
-'val1'
+'val2'

EOF
            ,
            $message
        );
    }


    public function testFailAssociativeAssertion()
    {
        $actual = [
            'firstname' => 'Seiya',
            'deeper'    => [
                'key1' => 'val1',
                'key2' => '2018-02-28 11:11:11',
                'key3' => ['val1', 'val2', 11]
            ]
        ];

        $expected = [
            'firstname' => 'Seiya',
            'deeper'    => [
                'key1' => AA::assertObject(),
                'key2' => AA::assertDateTimeStr('Y-m-d H:i:s'),
                'key3' => AA::assertArray()
            ]
        ];

        $message = '';
        try {
            $this->assertAssociativeArray($expected, $actual);
        } catch (ExpectationFailedException $exception) {
            $message = $exception->getMessage();
        }

        $this->assertEquals('Failed asserting that \'val1\' is of type "object".', $message);
    }
}