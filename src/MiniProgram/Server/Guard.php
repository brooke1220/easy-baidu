<?php

namespace EasyBaidu\MiniProgram\Server;

use EasyWeChat\Kernel\ServerGuard;
use EasyWeChat\Kernel\Messages\Message;
use Symfony\Component\HttpFoundation\Response;
use EasyBaidu\Kernel\Traits\InteractsWithSafe;

class Guard extends ServerGuard
{
    use InteractsWithSafe;

    const EVENT_MAPPING = [
        'PACKAGE_AUDIT_FAIL' => Message::EVENT,
        'PACKAGE_AUDIT_PASS' => Message::EVENT
    ];

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resolve(): Response
    {
         $message = $this->getMessage();

         if (isset($message['event']) && array_key_exists($message['event'], static::EVENT_MAPPING)) {
             $this->dispatch(static::EVENT_MAPPING[$message['event']], $message);

             return new Response(static::SUCCESS_EMPTY_RESPONSE);
         }

         return parent::resolve();
     }

    /**
     * @return bool
     */
    protected function shouldReturnRawResponse(): bool
    {
        $message = $this->getMessage();

        return isset($message['event']) && array_key_exists($message['event'], static::EVENT_MAPPING);
    }
}
