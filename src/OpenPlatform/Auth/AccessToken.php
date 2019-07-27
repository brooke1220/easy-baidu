<?php

namespace EasyBaidu\OpenPlatform\Auth;

use EasyWeChat\Kernel\AccessToken as BaseAccessToken;
use EasyWeChat\Kernel\Support\Arr;
use EasyWeChat\Kernel\Exceptions\HttpException;
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
    protected $requestMethod = 'GET';

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $endpointToGetToken = 'public/2.0/smartapp/auth/tp/token';

    /**
     * @param bool $refresh
     *
     * @return array
     *
     * @throws \EasyWeChat\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function getToken(bool $refresh = false): array
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $result = $this->requestToken($this->getCredentials(), true);

        $token = Arr::get($result, 'data');

        $this->setToken($token[$this->tokenKey], $token['expires_in'] ?? 7200);

        return $token;
    }

    /**
     * @return array
     */
    protected function getCredentials(): array
    {
        return [
            'client_id' => $this->app['config']['app_key'],
            'ticket' => $this->app['verify_ticket']->getTicket(),
        ];
    }

    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->sendRequest($credentials);
        $result = json_decode($response->getBody()->getContents(), true);
        $formatted = $this->castResponseToType($response, $this->app['config']->get('response_type'));

        if (empty(Arr::get($result, 'data.'.$this->tokenKey))) {
            throw new HttpException('Request access_token fail: '.json_encode($result, JSON_UNESCAPED_UNICODE), $response, $formatted);
        }

        return $toArray ? $result : $formatted;
    }
}
