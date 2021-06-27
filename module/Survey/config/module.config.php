<?php

declare(strict_types=1);

namespace Arp\Survey;

use Arp\Survey\Controller\Factory\SurveyControllerFactory;
use Arp\Survey\Controller\HomeController;
use Arp\Survey\Controller\SurveyController;
use Arp\Survey\Entity\SurveyQuestion;
use Arp\Survey\Form\Factory\SurveyFormFactory;
use Arp\Survey\Form\SurveyForm;
use Arp\Survey\Service\Factory\SessionStorageServiceFactory;
use Arp\Survey\Service\Factory\SurveyResponseServiceFactory;
use Arp\Survey\Service\Factory\SurveyServiceFactory;
use Arp\Survey\Service\SessionStorageService;
use Arp\Survey\Service\SurveyResponseService;
use Arp\Survey\Service\SurveyService;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'survey' => [
        'questions' => [
            1 => [
                'title' => 'Please tell us your age',
                'type' => SurveyQuestion::TYPE_SELECT,
                'page' => 1,
                'options' => [
                    1 => 'Under 18',
                    2 => '18-30',
                    3 => '31-45',
                    4 => '45-60',
                    5 => '60+',
                ]
            ],

            2 => [
                'title' => 'From the following list, which of these animals is your favourite',
                'type' => SurveyQuestion::TYPE_MULTI_SELECT,
                'page' => 2,
                'options' => [
                    1 => 'Rabbit',
                    2 => 'Cat',
                    3 => 'Dog',
                    4 => 'Goldfish',
                ],
            ],

            3 => [
                'title' => 'What do you like about this animal',
                'type' => SurveyQuestion::TYPE_TEXT,
                'page' => 3,
            ]
        ],
    ],

    'router' => [
        'routes' => [
            // Landing page to start a survey
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => HomeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            // Page used to render the survey questions
            'survey' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/survey[/:page]',
                    'defaults' => [
                        'controller' => SurveyController::class,
                        'action'     => 'index',
                        'page'       => 1,
                    ],
                ],
            ],

            // Page used to render the survey results
            'complete' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/survey/complete',
                    'defaults' => [
                        'controller' => SurveyController::class,
                        'action'     => 'complete',
                    ],
                ],
            ],

            // Allow the reset of the provided responses
            'reset' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/survey/reset',
                    'defaults' => [
                        'controller' => SurveyController::class,
                        'action'     => 'reset',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            HomeController::class => InvokableFactory::class,
            SurveyController::class => SurveyControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            SurveyService::class => SurveyServiceFactory::class,
            SurveyResponseService::class => SurveyResponseServiceFactory::class,
            SessionStorageService::class => SessionStorageServiceFactory::class,
        ],
    ],

    'form_elements' => [
        'factories' => [
            SurveyForm::class => InvokableFactory::class,
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
