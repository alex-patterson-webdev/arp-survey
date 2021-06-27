<?php

declare(strict_types=1);

namespace Arp\Survey\Service;

interface StorageServiceInterface
{
    /**
     * Check if a survey exists within the storage
     *
     * @return bool
     */
    public function has(): bool;

    /**
     * Return the current survey data
     *
     * @return array
     */
    public function get(): array;

    /**
     * Persist the data of the survey
     *
     * @param array $data
     *
     * @return bool
     */
    public function save(array $data): bool;

    /**
     * Clear the session of any stored survey data
     *
     * @return bool
     */
    public function clear(): bool;
}
