<?php

namespace EasyBaidu\OpenPlatform\Server\Handlers;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\ServiceContainer;

/**
 * Class VerifyTicketRefreshed.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class VerifyTicketRefreshed implements EventHandlerInterface
{
    /**
     * @var \EasyWeChat\OpenPlatform\Application
     */
    protected $app;

    /**
     * Constructor.
     *
     * @param \EasyWeChat\OpenPlatform\Application $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}.
     */
    public function handle($payload = null)
    {
        if (!empty($payload['Ticket'])) {
            $this->app['verify_ticket']->setTicket($payload['Ticket']);
        }
    }
}
