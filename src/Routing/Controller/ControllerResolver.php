<?php

namespace Pagekit\Routing\Controller;


use Pagekit\Routing\Event\GetControllerEvent;
use Pagekit\Decorator\Event\DecorateEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseResolver;

class ControllerResolver extends BaseResolver
{
    protected $events;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $events
     * @param LoggerInterface          $logger
     */
    public function __construct(EventDispatcherInterface $events, LoggerInterface $logger = null)
    {
        parent::__construct($logger);

        $this->events = $events;
    }

    /**
     * {@inheritdoc}
     */
    public function getController(Request $request)
    {
        $controller = $this->events->dispatch('controller.resolve', new GetControllerEvent($request))->getController() ?: parent::getController($request);
        if ($controller && is_array($controller) && is_object($controller[0])){
            $this->events->dispatch('decorators.decorate', $event = new DecorateEvent($controller[0]));
            $controller[0] = $event->getDecoratedObject();
        }
        return $controller;

    }
}
