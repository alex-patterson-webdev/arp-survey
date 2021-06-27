<?php

declare(strict_types=1);

namespace Arp\Survey\Service\Factory;

use Arp\Survey\Service\SessionStorageService;
use Arp\Survey\Service\SurveyResponseService;
use Psr\Container\ContainerInterface;

final class SurveyResponseServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $name
     * @param array|null         $options
     *
     * @return SurveyResponseService
     */
    public function __invoke(ContainerInterface $container, string $name, ?array $options = null): SurveyResponseService
    {
        return new SurveyResponseService(
            $container->get(SessionStorageService::class),
        );
    }
}
