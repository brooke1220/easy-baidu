<?php

namespace EasyBaidu\OpenPlatform\Authorizer\MiniProgram;


use EasyBaidu\OpenPlatform\Encryptor;
use EasyBaidu\OpenPlatform\Authorizer\Auth\AccessToken;
use EasyBaidu\OpenPlatform\Application as OpenPlatform;
use EasyBaidu\MiniProgram\Application as MiniProgram;

use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\OpenPlatform\Authorizer\Aggregate\AggregateServiceProvider;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Account\Client $account
 * @property \EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Code\Client    $code
 * @property \EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Domain\Client  $domain
 * @property \EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Setting\Client $setting
 * @property \EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Tester\Client  $tester
 */
class Application extends MiniProgram
{
    /**
     * @var \EasyBaidu\OpenPlatform\Application
     */
    protected $component;

    /**
     * Application constructor.
     *
     * @param array $config
     * @param array $prepends
     */
     public function __construct(ServiceContainer $miniProgram, OpenPlatform $component)
     {
         parent::__construct($miniProgram);

         $providers = [
             // AggregateServiceProvider::class,
             Code\ServiceProvider::class,
             Domain\ServiceProvider::class,
             Account\ServiceProvider::class,
             Auth\ServiceProvider::class,
             // Setting\ServiceProvider::class,
             // Tester\ServiceProvider::class
         ];

         foreach ($providers as $provider) {
             $this->register(new $provider());
         }

         $this->component = $component;

         $this->registerAccessToken()
            ->rebindModules();
     }

     public function registerAccessToken()
     {
         $this['access_token'] = function(){
             return new AccessToken($this->resource, $this->component);
         };

         return $this;
     }

     public function rebindModules()
     {
         $this->rebindAccessToken($this)
             ->rebindEncryptor($this);
     }

     public function rebindAccessToken($app)
     {
         $app->rebind('access_token', $this['access_token']);

         return $this;
     }

     public function rebindEncryptor($app)
     {
         $app->rebind('encryptor', new Encryptor(
             $this->component['config']['app_id'],
             $this->component['config']['token'],
             $this->component['config']['aes_key']
         ));

         return $this;
     }

     public function registerTokenHandlers(callable $callable)
     {
         $this->access_token->on(AccessToken::EVENT_ACCESS_TOKEN, $callable);
     }
}
