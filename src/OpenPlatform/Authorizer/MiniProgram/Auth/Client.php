<?php

namespace EasyBaidu\OpenPlatform\Authorizer\MiniProgram\Auth;

use EasyWeChat\Kernel\BaseClient;


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
            'grant_type' => 'authorization_code'
        ];

        return $this->httpGet('rest/2.0/oauth/getsessionkeybycode', $params);
    }
}
