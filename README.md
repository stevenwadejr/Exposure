# Exposure

> "Make your privates public".

Have you ever needed access to private/protected object properties or methods? Of course they're private/protected for a reason... but, sometimes you just _need_ them. 

**Exposure** _exposes_ private and protected properties and methods as well as allowing for new methods to be added to an object _after_ instantiation.

## Installation

Via Composer

```
composer require stevenwadejr/exposure
```

## What's new in 0.3.0?

You can now expose your objects _and_ benefit from type hinting. Exposure now comes with a factory to create a new instance of `Exposure` that extends your closed class.

Example:

```php
use StevenWadeJr\Exposure\Factory;

class CantTouchThis
{
    private $privateParty = 'This is private';
}

$exposed = Factory::expose(new CantTouchThis);
```

```php
echo $exposed->privateParty; // outputs 'This is private'
var_dump($exposed instanceof CantTouchThis); // outputs 'true'
```

## Example

```php
<?php
use StevenWadeJr\Exposure\Exposure;

class CantTouchThis
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

$exposure = new Exposure(new CantTouchThis);
```

### Access public properties and methods

```php
echo $exposure->publicProperty; // outputs 'This is public'
echo $exposure->publicMethod(); // outputs 'This is a public method'
```

### Inaccessible properties and methods

```php
echo $exposure->privateProperty; // outputs 'This is private'
echo $exposure->protectedMethod(); // outputs 'This is a protected method'
```

### Overwrite protected properties

```php
$exposure->protectedProperty = 'New protected property';
echo $exposure->protectedProperty; // outputs 'New protected property'
```

### Add a new method to the object

```php
$exposure->__methods('setProtectedProperty', function()
{
    $this->protectedProperty = 'Whoops, I touched this!';
});
$exposure->setProtectedProperty();
echo $exposure->protectedProperty; // outputs 'Whoops, I touched this!'
```

## Why?

Obviously, try to follow the [Open/Closed Principle](https://www.wikiwand.com/en/Open/closed_principle) whenever possible, and there are rarely ever any circumstances when you _should_ actually use this class, but sometimes there are. 

## Uses

Production? Please don't. Testing? Sure!
