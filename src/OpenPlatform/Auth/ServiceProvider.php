<?php

namespace EasyBaidu\OpenPlatform\Auth;

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
        $app['verify_ticket'] = function ($app) {
            return new VerifyTicket($app->resource);
        };

        $app['access_token'] = function ($app) {
            return new AccessToken($app->resource);
        };
    }
}
