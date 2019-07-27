<?php

namespace EasyBaidu\Kernel\Traits;

use EasyWeChat\Kernel\Exceptions\BadRequestException;

trait InteractsWithSafe
{
    /**
     * Check the request message safe mode.
     *
     * @return bool
     */
    protected function isSafeMode(): bool
    {
        return !empty($this->app['request']->post('MsgSignature'));
    }

    /**
     * @return $this
     *
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     */
    public function validate()
    {
        if (!$this->alwaysValidate && !$this->isSafeMode()) {
            return $this;
        }

        if ($this->app['request']->get('msg_signature') !== $this->signature([
                $this->getToken(),
                $this->app['request']->get('timestamp'),
                $this->app['request']->get('nonce'),
                $this->app['request']->get('encrypt'),
            ])) {
            throw new BadRequestException('Invalid request signature.', 400);
        }

        return $this;
    }
}
