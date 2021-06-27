<?php

declare(strict_types=1);

namespace Arp\Survey\Service\Factory;

use Laminas\Session\Config\SessionConfig;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\SessionArrayStorage;
use Psr\Container\ContainerInterface;

final class SessionManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $name
     * @param array|null         $options
     *
     * @return SessionManager
     */
    public function __invoke(ContainerInterface $container, string $name, ?array $options = null): SessionManager
    {
        $config = $container->get('config')['session_manager']['config'] ?? [];
        $configClass = $config['class'] ?? SessionConfig::class;

        /** @var SessionConfig $sessionConfig */
        $sessionConfig = new $configClass();
        if (!empty($config['options'])) {
            $sessionConfig->setOptions($config['options']);
        }

        return new SessionManager($sessionConfig, new SessionArrayStorage());
    }
}
