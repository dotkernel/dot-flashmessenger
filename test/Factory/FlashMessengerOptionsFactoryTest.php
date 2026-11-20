<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Factory;

use Dot\FlashMessenger\ConfigProvider;
use Dot\FlashMessenger\Factory\FlashMessengerOptionsFactory;
use DotTest\FlashMessenger\CommonTrait;
use DotTest\FlashMessenger\Fixture\InMemoryContainer;
use PHPUnit\Framework\TestCase;

class FlashMessengerOptionsFactoryTest extends TestCase
{
    use CommonTrait;

    public function testOptionsComeFromTheConfig(): void
    {
        $container = new InMemoryContainer(['config' => $this->config]);

        $result = (new FlashMessengerOptionsFactory())($container);

        $this->assertSame($this->config['dot_flashmessenger']['options'], $result->getOptions());
    }

    public function testDefaultConfigProviderGivesTheNamespace(): void
    {
        $container = new InMemoryContainer(['config' => (new ConfigProvider())()]);

        $result = (new FlashMessengerOptionsFactory())($container);

        $this->assertSame(['namespace' => 'dot_messenger'], $result->getOptions());
    }

    public function testMissingConfigGivesEmptyOptions(): void
    {
        $factory = new FlashMessengerOptionsFactory();

        $this->assertSame([], $factory(new InMemoryContainer(['config' => []]))->getOptions());
        $this->assertSame([], $factory(new InMemoryContainer())->getOptions());
    }
}
