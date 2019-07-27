<?php

namespace EasyBaidu\OpenPlatform\Server;

use EasyWeChat\Kernel\ServerGuard;
use EasyBaidu\Kernel\Traits\InteractsWithSafe;
use EasyWeChat\OpenPlatform\Server\Handlers\Authorized;
use EasyWeChat\OpenPlatform\Server\Handlers\Unauthorized;
use EasyWeChat\OpenPlatform\Server\Handlers\UpdateAuthorized;
use EasyBaidu\OpenPlatform\Server\Handlers\VerifyTicketRefreshed;
use Symfony\Component\HttpFoundation\Response;
use EasyWeChat\Kernel\Messages\Message;
/**
 * Class Guard.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Guard extends ServerGuard
{
    use InteractsWithSafe;

    const EVENT_AUTHORIZED = 'AUTHORIZED';
    const EVENT_UNAUTHORIZED = 'UNAUTHORIZED';
    const EVENT_COMPONENT_VERIFY_TICKET = 'ticket';

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resolve(): Response
    {
         $this->registerHandlers();

         $message = $this->getMessage();

         if (isset($message['MsgType'])) {
             $this->dispatch($message['MsgType'], $message);
         }else if(isset($message['event'])) {
             $this->dispatch($message['event'], $message);
         }

         return new Response(static::SUCCESS_EMPTY_RESPONSE);
     }

    /**
     * Register event handlers.
     */
    protected function registerHandlers()
    {
        $this->on(self::EVENT_AUTHORIZED, Authorized::class);
        $this->on(self::EVENT_UNAUTHORIZED, Unauthorized::class);
        $this->on(self::EVENT_COMPONENT_VERIFY_TICKET, VerifyTicketRefreshed::class);
    }
}
