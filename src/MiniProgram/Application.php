<?php

namespace EasyBaidu\MiniProgram;

use EasyBaidu\Kernel\ServiceContainer;
use EasyBaidu\OpenPlatform\Application as OpenPlatform;

use EasyWeChat\Kernel\ServiceContainer as WechatServiceContainer;

/**
 * Class Application.
 *
 * @author brooke <overbob@yeah.net>
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Server\ServiceProvider::class,
    ];

    /**
     * Application constructor.
     *
     * @param array $config
     * @param array $prepends
     */
     public function __construct(WechatServiceContainer $miniProgram)
     {
         parent::__construct($miniProgram);
     }
}
