<?php

declare(strict_types=1);

namespace Arp\Survey\Service;

use Arp\Survey\Entity\Answer;
use Arp\Survey\Entity\SurveyQuestion;
use Arp\Survey\Entity\SurveyResponse;

class SurveyResponseService
{
    /**
     * Service used to persist the survey data
     *
     * @var StorageServiceInterface
     */
    private StorageServiceInterface $storage;

    /**
     * @param StorageServiceInterface $storage
     */
    public function __construct(StorageServiceInterface $storage)
    {
        $this->storage = $storage;
    }

    public function saveResponse(SurveyResponse $surveyResponse)
    {

    }

    /**
     * @param SurveyQuestion $question
     * @param mixed          $value
     *
     * @return Answer
     */
    public function createAnswer(SurveyQuestion $question, $value): Answer
    {
        return new Answer($question, $value);
    }
}
