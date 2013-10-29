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
}