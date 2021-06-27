<?php

declare(strict_types=1);

namespace Arp\Survey\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class HomeController extends AbstractActionController
{
    /**
     * Render the survey home page
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $view = new ViewModel();
        $view->setTemplate('survey/home/index');
        return $view;
    }
}
