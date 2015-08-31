<?php
namespace StevenWadeJr\Exposure;

use \Closure;

class Exposure
{
    protected $_exposureClass;

    protected $_exposureClassName;

    protected $_exposureMethods = [];

    public function __construct($class)
    {
        $this->_exposureClass = $class;
        $this->_exposureClassName = get_class($class);
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
        if (isset($this->_exposureMethods[$method])) {
            return call_user_func_array($this->_exposureMethods[$method], $args);
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
            return $this->_exposureMethods;
        }

        if (! is_null($name) && is_null($closure)) {
            return $this->_exposureMethods[$name];
        }

        if (! is_null($name) && ! is_null($closure)) {
            $this->_exposureMethods[$name] = $this->__bind($closure);
        }
    }

    private function __bind(Closure $closure)
    {
        return Closure::bind($closure, $this->_exposureClass, "\\$this->_exposureClassName");
    }
}
