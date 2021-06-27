<?php

declare(strict_types=1);

namespace Arp\Survey\Entity;

class SurveyResponse
{
    /**
     * @var array<Answer>
     */
    private array $answers;

    /**
     * @param array<Answer> $answers
     */
    public function __construct(array $answers = [])
    {
        $this->setAnswers($answers);
    }

    /**
     * Return the answer for a given question id, or null if not found
     *
     * @param int $questionId
     *
     * @return Answer|null
     */
    public function getAnswer(int $questionId): ?Answer
    {
        return $this->answers[$questionId] ?? null;
    }

    /**
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param array<Answer> $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = [];
        foreach ($answers as $answer) {
            $this->setAnswer($answer);
        }
    }

    /**
     * Add a answer to the collection, keyed by the question id
     *
     * @param Answer $answer
     */
    public function setAnswer(Answer $answer): void
    {
        $this->answers[$answer->getQuestionId()] = $answer;
    }

    /**
     * Return the answer collection in array format
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this->answers as $questionId => $answer) {
            $data[$questionId] = $answer->getValue();
        }

        return $data;
    }
}
