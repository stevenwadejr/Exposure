<?php
namespace StevenWadeJr\PublicServant\Tests;

use StevenWadeJr\PublicServant\PublicServant;

class PublicServantTest extends \PHPUnit_Framework_TestCase
{
    protected $publicServant;

    public function setUp()
    {
        $this->publicServant = new PublicServant(new TestSubject);
    }

    public function test_can_access_private_property()
    {
        $this->assertEquals('This is private', $this->publicServant->privateProperty);
    }

    public function test_can_access_private_method()
    {
        $this->assertEquals('This is a private method', $this->publicServant->privateMethod());
    }

    public function test_add_new_method_binds_to_testsubject()
    {
        $this->assertEquals('This is protected', $this->publicServant->protectedProperty);

        $this->publicServant->__methods('setProtectedProperty', function()
        {
            $this->protectedProperty = 'I changed a protected property';
        });

        $this->publicServant->setProtectedProperty();

        $this->assertEquals(
            'I changed a protected property', 
            $this->publicServant->protectedProperty
        );
    }
}