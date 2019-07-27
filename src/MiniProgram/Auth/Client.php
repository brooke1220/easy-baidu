<?php

namespace EasyBaidu\MiniProgram\Auth;

use EasyWeChat\Kernel\BaseClient;

/**
 * Class Auth.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get session info by code.
     *
     * @param string $code
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function session(string $code)
    {
        $params = [
            'code' => $code,
            'client_id' => $this->app['config']['app_id'],
            'sk' => $this->app['config']['secret']
        ];

        return $this->httpGet('oauth/jscode2sessionkey', $params);
    }
}
