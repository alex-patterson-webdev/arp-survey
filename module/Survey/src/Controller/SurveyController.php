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
     * Handle the rendering of the survey questions
     *
     * @return ViewModel|Response
     */
    public function indexAction()
    {
        $survey = $this->surveyService->createSurvey();
        $response = $this->responseService->loadResponse($survey);
        $page = (int)$this->params()->fromRoute('page');

        $form = $this->surveyForm->createElements($survey, $page, $response);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid() && $this->responseService->save($survey, $form->getData())) {
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
     * Allow a new survey to be completed, resetting any existing responses
     *
     * @return Response
     */
    public function resetAction(): Response
    {
        $this->responseService->clearResponse();

        return $this->redirect()->toRoute('survey');
    }

    /**
     * Display the survey completion page
     *
     * @return ViewModel
     */
    public function completeAction(): ViewModel
    {
        $survey = $this->surveyService->createSurvey();
        $response = $this->responseService->loadResponse($survey);

        $view = new ViewModel(['response' => $response]);
        $view->setTemplate('survey/survey/complete');
        return $view;
    }
}
