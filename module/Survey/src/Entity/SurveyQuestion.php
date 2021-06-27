<?php

declare(strict_types=1);

namespace Arp\Survey\Entity;

class SurveyQuestion
{
    public const TYPE_TEXT = 'text';
    public const TYPE_SELECT = 'select';
    public const TYPE_MULTI_SELECT = 'multi-select';

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var array<QuestionOption>
     */
    private array $options = [];

    /**
     * @var int
     */
    private int $page;

    /**
     * @param int    $id
     * @param string $title
     * @param string $type
     * @param array  $options
     * @param int    $page
     */
    public function __construct(int $id, string $title, string $type, array $options = [], int $page = 1)
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->page = $page;

        $this->setOptions($options);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return array<QuestionOption>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array<QuestionOption> $options
     */
    public function setOptions(array $options): void
    {
        $this->options = [];
        foreach ($options as $option) {
            $this->setOption($option);
        }
    }

    /**
     * @param QuestionOption $option
     */
    public function setOption(QuestionOption $option): void
    {
        $this->options[] = $option;
    }
}
