<?php

declare(strict_types=1);

namespace Arp\Survey\Entity;

class Answer
{
    /**
     * @var SurveyQuestion
     */
    private SurveyQuestion $question;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param SurveyQuestion $question
     * @param mixed          $value
     */
    public function __construct(SurveyQuestion $question, $value)
    {
        $this->question = $question;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getQuestionId(): int
    {
        return $this->question->getId();
    }

    /**
     * @return SurveyQuestion
     */
    public function getQuestion(): SurveyQuestion
    {
        return $this->question;
    }

    /**
     * @param SurveyQuestion $question
     */
    public function setQuestion(SurveyQuestion $question): void
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
