<?php

use Scandio\lmvc\utils\string\StringUtils;

/**
 * Class StringUtilsTest
 *
 * Tests the string utils.
 *  Note:
 *      Not fully sufficient but has decent code coverage. Should probably also test other
 *      delimiters and boundary values.
 */
class StringUtilsTest extends PHPUnit_Framework_TestCase
{
    private
        $camelCased1    = null,
        $uncamelCased1  = null;

    protected function setUp()
    {
        $this->camelCased1       = 'IamSoDeadCamelCased';
        $this->deCamelCased1     = 'iamSoDeadCamelCased';
        $this->uncamelCased1     = 'iam-so-dead-camel-cased';
    }

    public function testUnCamelCasing()
    {
        $this->assertEquals(StringUtils::camelCaseTo($this->camelCased1), $this->uncamelCased1);
    }

    public function testCamelCasing()
    {
        $this->assertEquals(StringUtils::camelCaseFrom($this->camelCased1), $this->deCamelCased1);
    }

    public function testBytesOfString()
    {
        $this->assertEquals(StringUtils::bytes($this->camelCased1), 19);
    }

    public function testStringStartsWith()
    {
        $this->assertTrue(StringUtils::starts("TobiasDeekens", "Tobias"));

        $this->assertFalse(StringUtils::starts("TobiasDeekens", "Tobiasss"));
        $this->assertFalse(StringUtils::starts("TobiasDeekens", "tobias"));
        $this->assertTrue(StringUtils::starts(strtolower("TobiasDeekens"), "tobias"));
    }

    public function testStringEndsWith()
    {
        $this->assertTrue(StringUtils::ends("TobiasDeekens", "Deekens"));

        $this->assertTrue(StringUtils::ends("TobiasDeekens", ""));

        $this->assertFalse(StringUtils::ends("TobiasDeekens", "Deekenssss"));
        $this->assertFalse(StringUtils::ends("TobiasDeekens", "deekens"));
        $this->assertTrue(StringUtils::ends(strtolower("TobiasDeekens"), "deekens"));
    }
}