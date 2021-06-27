<?php

declare(strict_types=1);

namespace Arp\Survey\Service;

use Arp\Survey\Entity\QuestionOption;
use Arp\Survey\Entity\Survey;
use Arp\Survey\Entity\SurveyQuestion;
use Arp\Survey\Service\Exception\InvalidArgumentException;

class SurveyService
{
    /**
     * Survey question configuration data
     *
     * @var array<mixed>
     */
    private array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Create a new Survey instance and populate it with the required question data
     *
     * @return Survey
     *
     * @throws InvalidArgumentException
     */
    public function createSurvey(): Survey
    {
        if (empty($this->config['questions'])) {
            throw new InvalidArgumentException(
                'The survey configuration is missing the required \'questions\' configuration key'
            );
        }

        return new Survey($this->createQuestions($this->config['questions']));
    }

    /**
     * Create a collection of SurveyQuestion instances from the provided $config
     *
     * @param array $config
     *
     * @return array<SurveyQuestion>
     */
    private function createQuestions(array $config): array
    {
        $questions = [];
        foreach ($config as $id => $questionData) {
            $questions[$id] = $this->createQuestion($id, $questionData);
        }

        return $questions;
    }

    /**
     * Create a single SurveyQuestion instance and populate it with the provided $questionData
     *
     * @param int   $id
     * @param array $questionData
     *
     * @return SurveyQuestion
     */
    private function createQuestion(int $id, array $questionData): SurveyQuestion
    {
        if (empty($questionData['title'])) {
            throw new InvalidArgumentException(
                sprintf('The required \'title\' configuration value is missing for question \'%d\'', $id)
            );
        }

        if (empty($questionData['type'])) {
            throw new InvalidArgumentException(
                sprintf('The required \'type\' configuration value is missing for question \'%d\'', $id)
            );
        }

        if (empty($questionData['page'])) {
            $questionData['page'] = 1;
        }

        $question = new SurveyQuestion(
            $id,
            $questionData['title'],
            $questionData['type'],
            $questionData['page']
        );

        if (!empty($questionData['options'])) {
            $question->setOptions($this->createQuestionOptions($questionData['options']));
        }

        return $question;
    }

    /**
     * Create a collection of question options from the provided $data
     *
     * @param array $data
     *
     * @return array<QuestionOption>
     */
    public function createQuestionOptions(array $data): array
    {
        $options = [];
        foreach ($data as $value => $title) {
            $options[$value] = new QuestionOption($title, $value);
        }

        return $options;
    }
}
