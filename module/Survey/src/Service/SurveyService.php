<?php

declare(strict_types=1);

namespace Arp\Survey\Service;

use Arp\Survey\Entity\QuestionOption;
use Arp\Survey\Entity\Survey;
use Arp\Survey\Entity\SurveyQuestion;
use Arp\Survey\Entity\SurveyResponse;
use Arp\Survey\Service\Exception\InvalidArgumentException;

class SurveyService
{
    /**
     * Service used to persist the survey data
     *
     * @var StorageServiceInterface
     */
    private StorageServiceInterface $storage;

    /**
     * Survey question configuration data
     *
     * @var array<mixed>
     */
    private array $config;

    /**
     * @param StorageServiceInterface $storage
     * @param array                   $config
     */
    public function __construct(StorageServiceInterface $storage, array $config)
    {
        $this->storage = $storage;
        $this->config = $config;
    }

    public function createSurvey(): Survey
    {
        return new Survey(
            $this->createQuestions()
        );
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
            $questionData['title'],
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

    }


    public function saveSurveyResponse(SurveyResponse $response): bool
    {

    }
}
