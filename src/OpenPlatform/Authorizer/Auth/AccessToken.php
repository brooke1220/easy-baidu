<?php

namespace EasyBaidu\OpenPlatform\Authorizer\Auth;

use EasyWeChat\Kernel\AccessToken as BaseAccessToken;
use EasyBaidu\OpenPlatform\Application;
use Pimple\Container;
use EasyWeChat\Kernel\Exceptions\HttpException;
use EasyWeChat\Kernel\Support\Collection;
use EasyWeChat\Kernel\Traits\Observable;
use EasyWeChat\Kernel\Support\Arr;

/**
 * Class AccessToken.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class AccessToken extends BaseAccessToken
{
    use Observable;

    const EVENT_ACCESS_TOKEN = 'access_token';

    /**
     * {@inheritdoc}.
     */
    protected $tokenKey = 'access_token';

    /**
     * @var \EasyWeChat\OpenPlatform\Application
     */
    protected $component;

    /**
     * AuthorizerAccessToken constructor.
     *
     * @param \Pimple\Container                    $app
     * @param \EasyWeChat\OpenPlatform\Application $component
     */
    public function __construct(Container $app, Application $component)
    {
        parent::__construct($app);

        $this->component = $component;
    }

    /**
     * {@inheritdoc}.
     */
    protected function getCredentials(): array
    {
        return [
            'refresh_token' => $this->app['config']['refresh_token'],
            'grant_type' => 'app_to_tp_refresh_token'
        ];
    }

    public function requestToken(array $credentials, $toArray = false)
    {
        $result = $formatted = $this->component->getAuthorizerToken($credentials);

        if($formatted instanceof Collection){
            $result = $formatted->toArray();
        }
        if (empty($result[$this->tokenKey])) {
            throw new HttpException('Request access_token fail: '.json_encode($result, JSON_UNESCAPED_UNICODE));
        }

        $this->dispatch(static::EVENT_ACCESS_TOKEN, $result);

        return $toArray ? $result : $formatted;
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->cachePrefix.md5(json_encode(array_merge(['authorizer_appid' => $this->app['config']['app_id']], Arr::except($this->getCredentials(), ['refresh_token']))));
    }
}
