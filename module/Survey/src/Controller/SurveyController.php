<?php

declare(strict_types=1);

namespace Arp\Survey\Controller;

use Arp\Survey\Form\SurveyForm;
use Arp\Survey\Service\SurveyResponseService;
use Arp\Survey\Service\SurveyService;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SurveyController extends AbstractActionController
{
    /**
     * @var SurveyService
     */
    private SurveyService $surveyService;

    /**
     * @var SurveyResponseService
     */
    private SurveyResponseService $responseService;

    /**
     * @var SurveyForm
     */
    private SurveyForm $surveyForm;

    /**
     * @param SurveyService         $surveyService
     * @param SurveyResponseService $responseService
     * @param SurveyForm            $surveyForm
     */
    public function __construct(
        SurveyService $surveyService,
        SurveyResponseService $responseService,
        SurveyForm $surveyForm
    ) {
        $this->surveyService = $surveyService;
        $this->responseService = $responseService;
        $this->surveyForm = $surveyForm;
    }

    /**
     * @return ViewModel|Response
     */
    public function indexAction()
    {
        $survey = $this->surveyService->createSurvey();
        $response = $this->responseService->loadResponse($survey);

        $page = (int)$this->params()->fromRoute('page');
        $form = $this->surveyForm;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($this->params()->fromPost());

            if ($form->isValid() && $this->responseService->save($response)) {
                if ($page < 3) {
                    return $this->redirect()->toRoute('survey', ['page' => ++$page]);
                }
                return $this->redirect()->toRoute('complete');
            }
        }

        $view = new ViewModel(compact('survey', 'page', 'form'));
        $view->setTemplate('survey/survey/index');
        return $view;
    }

    /**
     * @return ViewModel
     */
    public function completeAction(): ViewModel
    {
        $view = new ViewModel();
        $view->setTemplate('survey/survey/complete');
        return $view;
    }
}
