<?php
namespace StevenWadeJr\PublicServant\Tests;

class TestSubject
{
    public $publicProperty = 'This is public';

    protected $protectedProperty = 'This is protected';

    private $privateProperty = 'This is private';

    public function publicMethod()
    {
        return 'This is a public method';
    }

    protected function protectedMethod()
    {
        return 'This is a protected method';
    }

    private function privateMethod()
    {
        return 'This is a private method';
    }
}