<?php

declare(strict_types=1);

namespace Arp\Survey\Service;

use Laminas\Session\Container;

final class SessionStorageService implements StorageServiceInterface
{
    /**
     * Session storage container
     *
     * @var Container
     */
    private Container $container;

    /**
     * Key used as the session namespace
     *
     * @var string
     */
    private string $key;

    /**
     * @param Container $container
     * @param string    $key
     */
    public function __construct(Container $container, string $key = 'survey')
    {
        $this->container = $container;
        $this->key = $key;
    }

    /**
     * @return bool
     */
    public function has(): bool
    {
        return !empty($this->container->{$this->key});
    }

    /**
     * Return the survey data in the current session
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function get(): array
    {
        $data = $this->container->{$this->key} ?? '';

        if (!empty($data)) {
            return (array)json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        }

        return [];
    }

    /**
     * Persist the data of the survey
     *
     * @param array $data
     *
     * @return bool
     *
     * @throws \JsonException
     */
    public function save(array $data): bool
    {
        $this->container->{$this->key} = json_encode($data, JSON_THROW_ON_ERROR);
        return true;
    }

    /**
     * Clear the session of any stored survey data
     *
     * @return bool
     */
    public function clear(): bool
    {
        $this->container->{$this->key} = [];
        return true;
    }
}
