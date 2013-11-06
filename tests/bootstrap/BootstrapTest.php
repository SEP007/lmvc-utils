<?php

use Scandio\lmvc\utils\bootstrap\Butler;

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

        static::$_bootstrap = new Scandio\lmvc\utils\test\Bootstrap();
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

    public function testBootstrapNamespace()
    {
        $this->assertEquals('Scandio\\lmvc\\utils\\test', static::$_bootstrap->getNamespace());
    }

    public function testBootstrapPath()
    {
        $this->assertEquals(dirname(__FILE__), static::$_bootstrap->getPath());
    }

    public function testBootstrapButler()
    {
        $bootstrapped = Butler::initialize('Scandio\\lmvc\\utils\\test');
        $bootstrapped = $bootstrapped[0];

        $this->assertInstanceOf('Scandio\\lmvc\\utils\\bootstrap\\BootstrapInterface', $bootstrapped);
        $this->assertTrue($bootstrapped->hasBeenInitialized());
    }
}