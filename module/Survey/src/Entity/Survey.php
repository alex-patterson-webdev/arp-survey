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
