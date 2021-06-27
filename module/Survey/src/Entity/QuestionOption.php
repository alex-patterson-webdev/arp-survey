<?php

declare(strict_types=1);

namespace Arp\Survey\Entity;

class QuestionOption
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $title
     * @param mixed  $value
     */
    public function __construct(string $title, $value)
    {
        $this->title = $title;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
