<?php

declare(strict_types=1);

namespace Arp\Survey\Entity;

class Survey
{
    /**
     * @var array<SurveyQuestion>
     */
    private array $questions;

    /**
     * @param array<SurveyQuestion> $questions
     */
    public function __construct(array $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Return a question matching the provided $id, or NULL if not found
     *
     * @param int $id
     *
     * @return SurveyQuestion|null
     */
    public function getQuestion(int $id): ?SurveyQuestion
    {
        return $this->questions[$id] ?? null;
    }

    /**
     * Return the question collection
     *
     * @return SurveyQuestion[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * Return the questions for a given page number
     *
     * @param int $pageNumber
     *
     * @return array<SurveyQuestion>
     */
    public function getQuestionsForPage(int $pageNumber): array
    {
        return array_filter($this->questions, static function (SurveyQuestion $question) use ($pageNumber) {
            return ($pageNumber === $question->getPage());
        });
    }
}
