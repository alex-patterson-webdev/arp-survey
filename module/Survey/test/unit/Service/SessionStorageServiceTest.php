<?php

declare(strict_types=1);

namespace ArpTest\Survey\Service;

use Arp\Survey\Service\SessionStorageService;
use Arp\Survey\Service\StorageServiceInterface;
use Laminas\Session\Container;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\Survey\Service\SessionStorageService
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\Survey\Service
 */
final class SessionStorageServiceTest extends TestCase
{
    /**
     * @var Container&MockObject
     */
    private $container;

    /**
     * Prepare the test case dependencies
     */
    public function setUp(): void
    {
        $this->container = $this->createMock(Container::class);
    }

    /**
     * Assert that the class implements StorageServiceInterface
     */
    public function testImplementsStorageServiceInterface(): void
    {
        $service = new SessionStorageService($this->container);

        $this->assertInstanceOf(StorageServiceInterface::class, $service);
    }
}
