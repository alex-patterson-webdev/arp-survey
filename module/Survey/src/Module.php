<?php

declare(strict_types=1);

namespace Arp\Survey;

use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

final class Module
{
    /**
     * Return the module configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Prepare the application
     *
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event): void
    {
        $container = $event->getApplication()->getServiceManager();

        // Set the session containers default manager
        Container::setDefaultManager($container->get(SessionManager::class));
    }
}
