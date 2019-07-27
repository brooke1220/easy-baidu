<?php

namespace EasyBaidu\OpenPlatform\Base;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['base'] = function ($app) {
            return new Client($app->resource);
        };
    }
}
