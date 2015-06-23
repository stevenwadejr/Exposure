<?php
namespace StevenWadeJr\Exposure\Tests;

use StevenWadeJr\Exposure\Exposure;

class ExposureTest extends \PHPUnit_Framework_TestCase
{
    protected $exposure;

    public function setUp()
    {
        $this->exposure = new Exposure(new TestSubject);
    }

    public function test_can_access_private_property()
    {
        $this->assertEquals('This is private', $this->exposure->privateProperty);
    }

    public function test_can_access_private_method()
    {
        $this->assertEquals('This is a private method', $this->exposure->privateMethod());
    }

    public function test_add_new_method_binds_to_testsubject()
    {
        $this->assertEquals('This is protected', $this->exposure->protectedProperty);

        $this->exposure->__methods('setProtectedProperty', function()
        {
            $this->protectedProperty = 'I changed a protected property';
        });

        $this->exposure->setProtectedProperty();

        $this->assertEquals(
            'I changed a protected property', 
            $this->exposure->protectedProperty
        );
    }
}