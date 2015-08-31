<?php
namespace StevenWadeJr\Exposure\Tests;

use StevenWadeJr\Exposure\Exposure;
use StevenWadeJr\Exposure\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $exposure;

    protected $stub1 = <<<STUB
class StubbedFoo
{
    public function bar()
    {
        echo 'bar';
    }
}
STUB;

    protected $stub2 = <<<STUB
class StubbedFoo {
    public function bar()
    {
        echo 'bar';
    }
}
STUB;

    protected $stub3 = <<<STUB
class StubbedFoo{
    public function bar()
    {
        echo 'bar';
    }
}
STUB;


    public function setUp()
    {
        $this->exposure = new Exposure(new Factory);
    }

    public function testExpose()
    {
        $exposed = Factory::expose(new TestSubject);

        $this->assertTrue($exposed instanceof TestSubject);
    }

    public function testStub1ExtendsTestSubject()
    {
        $class = $this->exposure->extend(
            $this->stub1,
            'StubbedFoo1',
            '\StevenWadeJr\Exposure\Tests\TestSubject'
        );

        eval($class);
        $this->assertTrue(class_exists('StubbedFoo1'));
        $this->assertTrue((new \StubbedFoo1) instanceof TestSubject);
    }

    public function testStub2ExtendsTestSubject()
    {
        $class = $this->exposure->extend(
            $this->stub2,
            'StubbedFoo2',
            '\StevenWadeJr\Exposure\Tests\TestSubject'
        );

        eval($class);
        $this->assertTrue(class_exists('StubbedFoo2'));
        $this->assertTrue((new \StubbedFoo2) instanceof TestSubject);
    }

    public function testStub3ExtendsTestSubject()
    {
        $class = $this->exposure->extend(
            $this->stub3,
            'StubbedFoo3',
            '\StevenWadeJr\Exposure\Tests\TestSubject'
        );

        eval($class);
        $this->assertTrue(class_exists('StubbedFoo3'));
        $this->assertTrue((new \StubbedFoo3) instanceof TestSubject);
    }

    public function testRenameStub()
    {
        $this->assertSame(
            'TestSubject_Exposed',
            $this->exposure->renameStub(get_class(new TestSubject))
        );
    }

    public function testStripNamespace()
    {
        $this->assertNotContains(
            'namespace',
            $this->exposure->stripNamespace(file_get_contents(__DIR__ . '/TestSubject.php'))
        );
    }
}
