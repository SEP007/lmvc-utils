<?php

use Scandio\lmvc\utils\bootstrap\Bootstrap;

/**
 * Class StringUtilsTest
 *
 * Tests the string utils.
 *  Note:
 *      Not fully sufficient but has decent code coverage. Should probably also test other
 *      delimiters and boundary values.
 */
class BootstrapTest extends PHPUnit_Framework_TestCase
{
    private static
        $_bootstrap = null;

    public static function setUpBeforeClass()
    {
        # Can't be autoloaded, overload of having a 2nd loader namespace is waste
        require_once('Bootstrap.php');

        static::$_bootstrap = new \Bootstrap();
    }

    public function testBootstrapInstanceType()
    {
        $this->assertInstanceOf('Scandio\\lmvc\\utils\\bootstrap\\BootstrapInterface', static::$_bootstrap);
    }

    public function testBootstrapInitialization()
    {
        $this->assertFalse(static::$_bootstrap->hasBeenInitialized());

        static::$_bootstrap->initialize();

        $this->assertTrue(static::$_bootstrap->hasBeenInitialized());
    }
}