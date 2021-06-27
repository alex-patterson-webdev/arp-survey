<?php

declare(strict_types=1);

namespace Arp\Survey\Service\Factory;

use Arp\Survey\Service\SessionStorageService;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Psr\Container\ContainerInterface;

final class SessionStorageServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $name
     * @param array|null         $options
     *
     * @return SessionStorageService
     */
    public function __invoke(ContainerInterface $container, string $name, ?array $options = null): SessionStorageService
    {
        /** @var ManagerInterface $sessionManager */
        $sessionManager = $container->get('ArpSessionManager');

        return new SessionStorageService(
            new Container('arp', $sessionManager)
        );
    }
}
