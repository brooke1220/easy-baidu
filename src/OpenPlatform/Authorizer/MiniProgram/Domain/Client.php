<?php

namespace EasyBaidu\OpenPlatform\Authorizer\MiniProgram\Domain;

use EasyWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * @param array $params
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function modify(array $params, $action = 'add')
    {
        $params = array_map(function($domains){
            return count($domains) > 0 ? implode(',', $domains) : '';
        }, $params);

        $params['action'] = $action;

        return $this->httpPostJson('rest/2.0/smartapp/app/modifydomain', $params);
    }


    /**
     * 设置小程序业务域名.
     *
     * @param array  $domains
     * @param string $action
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function setWebviewDomain(array $domains, $action = 'add')
    {
        $domains = count($domains) > 0 ? implode(',', $domains) : '';

        return $this->httpPostJson(
            'rest/2.0/smartapp/app/modifywebviewdomain',
            [ 'web_view_domain' => $domains, 'action' => $action  ]
        );
    }
}
