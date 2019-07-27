<?php

namespace EasyBaidu\Kernel;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use EasyBaidu\Kernel\Traits\InteractsWithResource;

class ServiceContainer extends Container
{
    use InteractsWithResource;

    public $resource;

    protected $providers = [];

    public function __construct($resource)
    {
        $this->resource = $resource;

        $this->registerProviders($this->getProviders());
    }

    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }

    public function register(ServiceProviderInterface $provider, array $values = array())
    {
        $provider->register($this);

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        return $this;
    }

    public function getProviders()
    {
        return $this->providers;
    }

    public function offsetGet($id)
    {
        if($this->offsetExists($id)){
            return parent::offsetGet($id);
        }

        return $this->resource[$id];
    }

    public function __get($key)
    {
        if($this->offsetExists($key)){
            return $this->offsetGet($key);
        }

        return $this->resource->{$key};
    }

    public function __isset($key)
    {
        return isset($this->resource->{$key});
    }

    public function __unset($key)
    {
        unset($this->resource->{$key});
    }

    protected function invoker($method, $arguments, $class = null)
    {
        if(is_null($class))  $class = $this->resource;

        return call_user_func_array([$class, $method], $arguments);
    }

    public function __call($method, $parameters)
    {
        return $this->invoker($method, $parameters);
    }
}
