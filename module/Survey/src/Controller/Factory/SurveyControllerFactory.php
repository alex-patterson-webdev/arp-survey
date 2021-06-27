<?php

declare(strict_types=1);

namespace Arp\Survey\Controller\Factory;

use Arp\Survey\Controller\SurveyController;
use Arp\Survey\Form\SurveyForm;
use Arp\Survey\Service\SurveyResponseService;
use Arp\Survey\Service\SurveyService;
use Psr\Container\ContainerInterface;

final class SurveyControllerFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $name
     * @param array|null         $options
     *
     * @return SurveyController
     */
    public function __invoke(ContainerInterface $container, string $name, ?array $options = []): SurveyController
    {
        return new SurveyController(
            $container->get(SurveyService::class),
            $container->get(SurveyResponseService::class),
            $container->get('FormElementManager')->get(SurveyForm::class)
        );
    }
}
