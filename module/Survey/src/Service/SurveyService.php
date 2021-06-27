<?php

declare(strict_types=1);

namespace Arp\Survey\Service;

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


}
