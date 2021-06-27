<?php

declare(strict_types=1);

namespace Arp\Survey\Service\Factory;

use Arp\Survey\Service\SurveyService;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

final class SurveyServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $name
     * @param array|null         $options
     *
     * @return SurveyService
     */
    public function __invoke(ContainerInterface $container, string $name, ?array $options = null): SurveyService
    {
        $config = $container->get('config')['survey'] ?? [];

        if (empty($config)) {
            throw new ServiceNotCreatedException(
                sprintf('The survey configuration cannot be empty for service \'%s\'', $name)
            );
        }

        return new SurveyService($config);
    }
}
