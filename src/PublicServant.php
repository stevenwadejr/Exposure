<?php
namespace StevenWadeJr\PublicServant;

use Closure;

class PublicServant
{
    protected $psClass;

    protected $psClassName;

    protected $psMethods = [];

    public function __construct($class)
    {
        $this->psClass = $class;
        $this->psClassName = get_class($class);
    }

    public function __get($property)
    {
        $closure = $this->__bind(function($property)
        {
            return $this->{$property};
        });

        return $closure($property);
    }

    public function __set($property, $value)
    {
        $closure = $this->__bind(function($property, $value)
        {
            $this->{$property} = $value;
        });

        return $closure($property, $value);
    }

    public function __call($method, $args)
    {
        if (isset($this->psMethods[$method])) {
            return call_user_func_array($this->psMethods[$method], $args);
        }
        
        $closure = $this->__bind(function($method, $args)
        {
            return call_user_func_array([$this, $method], $args);
        });

        return $closure($method, $args);
    }

    public function __methods($name = null, Closure $closure = null)
    {
        if (count(func_num_args()) === 0) {
            return $this->psMethods;
        }

        if (! is_null($name) && is_null($closure)) {
            return $this->psMethods[$name];
        }

        if (! is_null($name) && ! is_null($closure)) {
            $this->psMethods[$name] = $this->__bind($closure);
        }
    }

    private function __bind(Closure $closure)
    {
        return Closure::bind($closure, $this->psClass, "\\$this->psClassName");
    }
}