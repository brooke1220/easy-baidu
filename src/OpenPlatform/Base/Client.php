<?php

namespace EasyBaidu\OpenPlatform\Base;

use EasyWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get authorization info.
     *
     * @param string|null $authCode
     *
     * @return mixed
     */
    public function handleAuthorize(string $authCode = null)
    {
        $params = [
            'code' => $authCode ?? $this->app['request']->get('auth_code'),
            'grant_type' => 'app_to_tp_authorization_code'
        ];

        return $this->httpGet('rest/2.0/oauth/token', $params);
    }

    /**
     * Get authorizer info.
     *
     * @param string $appId
     *
     * @return mixed
     */
    public function getAuthorizer(string $appId)
    {
        $params = [
            'component_appid' => $this->app['config']['app_id'],
            'authorizer_appid' => $appId,
        ];

        return $this->httpPostJson('cgi-bin/component/api_get_authorizer_info', $params);
    }


    /**
     * Get authorizer access_token.
     *
     * @param string $appId
     *
     * @return mixed
     */
    public function getAuthorizerToken(array $credentials)
    {
        return $this->httpGet('rest/2.0/oauth/token', $credentials);
    }

    /**
     * Get options.
     *
     * @param string $appId
     * @param string $name
     *
     * @return mixed
     */
    public function getAuthorizerOption(string $appId, string $name)
    {
        $params = [
            'component_appid' => $this->app['config']['app_id'],
            'authorizer_appid' => $appId,
            'option_name' => $name,
        ];

        return $this->httpPostJson('cgi-bin/component/api_get_authorizer_option', $params);
    }

    /**
     * Set authorizer option.
     *
     * @param string $appId
     * @param string $name
     * @param string $value
     *
     * @return mixed
     */
    public function setAuthorizerOption(string $appId, string $name, string $value)
    {
        $params = [
            'component_appid' => $this->app['config']['app_id'],
            'authorizer_appid' => $appId,
            'option_name' => $name,
            'option_value' => $value,
        ];

        return $this->httpPostJson('cgi-bin/component/api_set_authorizer_option', $params);
    }

    /**
     * Get authorizer list.
     *
     * @param int $offset
     * @param int $count
     *
     * @return mixed
     */
    public function getAuthorizers($offset = 0, $count = 500)
    {
        $params = [
            'component_appid' => $this->app['config']['app_id'],
            'offset' => $offset,
            'count' => $count,
        ];

        return $this->httpPostJson('cgi-bin/component/api_get_authorizer_list', $params);
    }

    /**
     * Create pre-authorization code.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function createPreAuthorizationCode()
    {
        return $this->httpGet('rest/2.0/smartapp/tp/createpreauthcode');
    }

    /**
     * OpenPlatform Clear quota.
     *
     * @see https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419318587
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function clearQuota()
    {
        $params = [
            'component_appid' => $this->app['config']['app_id'],
        ];

        return $this->httpPostJson('cgi-bin/component/clear_quota', $params);
    }
}