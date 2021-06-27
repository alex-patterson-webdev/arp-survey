<?php

declare(strict_types=1);

namespace Arp\Survey\Form;

use Arp\Survey\Entity\Answer;
use Arp\Survey\Entity\Survey;
use Arp\Survey\Entity\SurveyQuestion;
use Arp\Survey\Entity\SurveyResponse;
use http\Env\Response;
use Laminas\Form\Form;

class SurveyForm extends Form
{
    /**
     * Create the form elements for the provided survey, optionally populating them with the provided $response
     *
     * @param Survey              $survey
     * @param int                 $page
     * @param SurveyResponse|null $response
     *
     * @return $this
     */
    public function createElements(Survey $survey, int $page = 1, ?SurveyResponse $response = null): SurveyForm
    {
        $this->setAttribute('class', 'form');

        // Modify question 3 answer to include answers provided in question 2
        $this->prepareLabels($survey, $response);
        foreach ($survey->getQuestionsForPage($page) as $question) {
            $answer = null;
            if (null !== $response) {
                $answer = $response->getAnswer($question->getId());
            }
            $this->add(
                $this->createQuestionElement($question, $answer)
            );
        }

        return $this;
    }

    /**
     * Create the form element array specification from the provided question
     *
     * @param SurveyQuestion $question
     * @param Answer|null    $answer
     *
     * @return array
     */
    private function createQuestionElement(SurveyQuestion $question, ?Answer $answer = null): array
    {
        $element = [
            'name'       => sprintf('question_%d', $question->getId()),
            'type'       => $question->getType(),
            'options'    => [
                'label' => $question->getTitle(),
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ];

        switch ($question->getType()) {
            case SurveyQuestion::TYPE_TEXT:
                $element['type'] = 'textarea';
            break;

            case SurveyQuestion::TYPE_SELECT:
                $element['type'] = 'select';
                $element['options']['empty_option'] = 'Please select...';
                $element['options']['value_options'] = $this->createOptions($question);
            break;

            case SurveyQuestion::TYPE_MULTI_SELECT:
                $element['type'] = 'select';
                $element['attributes']['multiple'] = true;
                $element['options']['empty_option'] = 'Please select...';
                $element['options']['value_options'] = $this->createOptions($question);
            break;
        }

        // Set the question value if provided/set
        if (null !== $answer) {
            $element['attributes']['value'] = $answer->getValue();
        }

        return $element;
    }

    /**
     * Create an array specification for the questions available options
     *
     * @param SurveyQuestion $question
     *
     * @return array
     */
    private function createOptions(SurveyQuestion $question): array
    {
        $options = [];
        foreach ($question->getOptions() as $option) {
            $options[$option->getValue()] = $option->getTitle();
        }

        return $options;
    }

    /**
     * Allow the survey's question labels to be modified by response answers
     *
     * @param Survey              $survey
     * @param SurveyResponse|null $response
     */
    private function prepareLabels(Survey $survey, ?SurveyResponse $response): void
    {
        if (null === $response) {
            return;
        }

        $answer2 = $response->getAnswer(2);
        $question2 = $survey->getQuestion(2);
        $question3 = $survey->getQuestion(3);

        if (null !== $answer2 && null !== $question2 && null !== $question3) {
            $optionLabels = [];
            foreach ($answer2->getValue() as $value) {
                $option = $question2->getOptionByValue((int)$value);
                if (null !== $option) {
                    $optionLabels[] = $option->getTitle();
                }
            }

            if (!empty($optionLabels)) {
                $question3->setTitle(
                    sprintf('What do you like about %s', implode(',', $optionLabels))
                );
            }
        }
    }
}
