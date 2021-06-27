<?php

declare(strict_types=1);

namespace Arp\Survey\Controller;

use Laminas\Http\PhpEnvironment\Request;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class HomeController extends AbstractActionController
{
    /**
     * Render the survey home page
     *
     * @return ViewModel|Response
     */
    public function indexAction()
    {
        /** @var Request $request */
        $request = $this->request;

        if ($request->getQuery('start')) {
            return $this->redirect()->toRoute('survey');
        }

        $view = new ViewModel();
        $view->setTemplate('survey/home/index');
        return $view;
    }
}
