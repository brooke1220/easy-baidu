<?php

namespace EasyBaidu\MiniProgram\Auth;

use EasyWeChat\Kernel\AccessToken as BaseAccessToken;

/**
 * Class AccessToken.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @var string
     */
    protected $endpointToGetToken = 'https://openapi.baidu.com/oauth/2.0/token';

    /**
     * {@inheritdoc}
     */
    protected function getCredentials(): array
    {
        return [
            'grant_type' => 'client_credentials',
            'client_id' => $this->app['config']['app_id'],
            'client_secret' => $this->app['config']['secret'],
            'scope' => 'smartapp_snsapi_base'
        ];
    }
}
