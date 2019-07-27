<?php

namespace EasyBaidu\OpenPlatform;

use EasyBaidu\Kernel\Http\Request;
use EasyBaidu\Kernel\ServiceContainer;
use EasyBaidu\OpenPlatform\Auth\AccessToken;
use EasyBaidu\OpenPlatform\Base\Client as BaseClient;

use EasyWeChat\OpenPlatform\Application as openPlatform;
use EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Application as MiniProgram;


class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Server\ServiceProvider::class,
        CodeTemplate\ServiceProvider::class
    ];

    public function __construct(openPlatform $openPlatform)
    {
        parent::__construct($openPlatform);

        $this->rebindModules();
    }

    public function rebindModules()
    {
        $this->rebindRequest($this)
            ->rebindAccessToken($this)
            ->rebindEncryptor($this)
            ->rebindBase($this);

        return $this;
    }

    public function rebindRequest($app)
    {
        $app->rebind('request', Request::createFromGlobals());

        return $this;
    }

    public function rebindAccessToken($app)
    {
        $app->rebind('access_token', new AccessToken($this->resource));

        return $this;
    }

    public function rebindEncryptor($app)
    {
        $app->rebind('encryptor', new Encryptor(
            $this['config']['app_id'],
            $this['config']['token'],
            $this['config']['aes_key']
        ));

        return $this;
    }

    public function rebindBase($app)
    {
        $app->rebind('base', new BaseClient($this->resource));

        return $this;
    }

    public function getPreAuthorizationUrl(string $callbackUrl, $optional = []): string
    {
        // 兼容旧版 API 设计
        if (\is_string($optional)) {
            $optional = [
                'pre_auth_code' => $optional,
            ];
        } else {
            $optional['pre_auth_code'] = $this->createPreAuthorizationCode()['data']['pre_auth_code'];
        }

        $queries = \array_merge($optional, [
            'client_id' => $this['config']['app_key'],
            'redirect_uri' => $callbackUrl,
        ]);

        return 'https://smartprogram.baidu.com/mappconsole/tp/authorization?'.http_build_query($queries);
    }
}
