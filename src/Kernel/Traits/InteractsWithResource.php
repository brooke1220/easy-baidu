<?php

namespace EasyBaidu\Kernel\Traits;

trait InteractsWithResource
{
    /**
     * Check the request message safe mode.
     *
     * @return bool
     */
    public function bindToResource($key, $value)
    {
        if(method_exists($this->resource, 'offsetSet')){
            $this->resource->offsetSet($key, $value);
        }

        $this->resource->{$key} = $value;
    }
}
