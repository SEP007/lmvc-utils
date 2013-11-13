<?php

use Scandio\lmvc\utils\logger\formatters\LineFormatter;

/**
 * Class StringUtilsTest
 *
 * Tests the string utils.
 *  Note:
 *      Not fully sufficient but has decent code coverage. Should probably also test other
 *      delimiters and boundary values.
 */
class TestLineFormatter extends PHPUnit_Framework_TestCase
{
    private
        $_formatter = null;

    protected function setUp()
    {
        $this->_formatter = new LineFormatter();
    }

    public function testSimpleStringFormat()
    {
        $this->assertEquals("Test String", $this->_formatter->format("Test String"));

        $this->assertEquals("Test String a but longer", $this->_formatter->format("Test String a but longer"));

        $this->assertNotEquals("Test", $this->_formatter->format("Test2"));
    }

    public function testFormattingWithContext()
    {
        $this->assertEquals("Test String", $this->_formatter->format("Test {variable}", ['variable' => "String"]));

        $this->assertEquals("Test Hello String", $this->_formatter->format("Test {var1} {var2}", ['var1' => "Hello", 'var2' => "String"]));
    }

    public function testFormattingObject()
    {
        $this->assertEquals(
            "Test {\"type\":\"Object\",\"extra\":\"stdClass\",\"payload\":{}}",
            $this->_formatter->format("Test {variable}", ['variable' => new \stdClass()])
        );
    }

    public function testFormattingDate()
    {
        $this->assertEquals(
            "Test {\"type\":\"Date\",\"extra\":null,\"payload\":\"\"}",
            $this->_formatter->format("Test {variable}", ['variable' => new \DateTime()])
        );
    }

    public function testFormattingException()
    {
        $this->assertTrue(
            strpos(
                $this->_formatter->format("Test {variable}", ['variable' => new \Exception()]),
                "Test {\"type\":\"Exception\",\"extra\":[\"Exception\",\"\/Volumes\/HDD\/Development\/sep007\/lmvc-utils\/tests\/logger\/formatters\/TestLineFormatter.php:59\"],\"payload\":\"\"}"
            ) !== false
        );
    }
}