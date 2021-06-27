<?php

declare(strict_types=1);

namespace Arp\Survey\Service;

use Arp\Survey\Entity\Answer;
use Arp\Survey\Entity\Survey;
use Arp\Survey\Entity\SurveyQuestion;
use Arp\Survey\Entity\SurveyResponse;
use Arp\Survey\Service\Exception\SurveyResponseServiceException;

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

    /**
     * Load the responses saved for the provided $survey
     *
     * @param Survey $survey
     *
     * @return SurveyResponse
     */
    public function loadResponse(Survey $survey): SurveyResponse
    {
        $response = new SurveyResponse();

        $answers = [];
        $data = $this->storage->get();

        if (!empty($data['answers'])) {
            foreach ($data['answers'] as $questionId => $value) {
                $question = $survey->getQuestion($questionId);
                if (null !== $question) {
                    $answers[] = $this->createAnswer($question, $value);
                }
            }
            $response->setAnswers($answers);
        }

        return $response;
    }

    /**
     * Save the responses provided to the survey
     *
     * @param Survey $survey
     * @param array  $data
     *
     * @return bool
     */
    public function save(Survey $survey, array $data = []): bool
    {
        $response = $this->loadResponse($survey);

        foreach ($data as $key => $value) {
            $questionId = (int)substr($key, strlen('question_'));
            if ($questionId <= 0) {
                continue;
            }
            $question = $survey->getQuestion($questionId);
            if ($question) {
                $response->setAnswer($this->createAnswer($question, $value));
            }
        }

        try {
            // Remove any existing data
            $this->storage->clear();

            // Save complete response
            $this->storage->save(['answers' => $response->toArray()]);
        } catch (\Exception $e) {
            throw new SurveyResponseServiceException(
                sprintf('The survey responses could not be saved: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        return true;
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

    /**
     * Remove any stored responses so we can submit a new one
     *
     * @return bool
     */
    public function clearResponse(): bool
    {
        if ($this->storage->has()) {
            $this->storage->clear();
            return true;
        }
        return false;
    }
}
