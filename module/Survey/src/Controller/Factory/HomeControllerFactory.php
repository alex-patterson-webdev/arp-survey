<?php

declare(strict_types=1);

namespace Arp\Survey\Controller\Factory;

use Arp\Survey\Controller\HomeController;
use Arp\Survey\Service\SurveyService;
use Psr\Container\ContainerInterface;

final class HomeControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $name
     * @param array|null         $options
     *
     * @return HomeController
     */
    public function __invoke(ContainerInterface $container, string $name, ?array $options = null): HomeController
    {
        return new HomeController(
            //$container->get(SurveyService::class)
        );
    }
}
