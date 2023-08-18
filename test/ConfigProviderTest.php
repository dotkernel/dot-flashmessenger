<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger;

use Dot\FlashMessenger\ConfigProvider;
use Dot\FlashMessenger\Factory\FlashMessengerFactory;
use Dot\FlashMessenger\Factory\FlashMessengerOptionsFactory;
use Dot\FlashMessenger\Factory\FlashMessengerRendererFactory;
use Dot\FlashMessenger\FlashMessenger;
use Dot\FlashMessenger\FlashMessengerInterface;
use Dot\FlashMessenger\Options\FlashMessengerOptions;
use Dot\FlashMessenger\View\FlashMessengerRenderer;
use Dot\FlashMessenger\View\RendererInterface;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    private array $config;

    public function setUp(): void
    {
        $this->config = (new ConfigProvider())();
    }

    public function testHasConfig(): void
    {
        $this->assertArrayHasKey('dependencies', $this->config);
        $this->assertArrayHasKey('dot_flashmessenger', $this->config);
        $this->assertArrayHasKey('options', $this->config['dot_flashmessenger']);
        $this->assertArrayHasKey('namespace', $this->config['dot_flashmessenger']['options']);

        $this->assertSame('dot_messenger', $this->config['dot_flashmessenger']['options']['namespace']);
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertSame(
            FlashMessengerFactory::class,
            $this->config['dependencies']['factories'][FlashMessenger::class]
        );
        $this->assertSame(
            FlashMessengerOptionsFactory::class,
            $this->config['dependencies']['factories'][FlashMessengerOptions::class]
        );
        $this->assertSame(
            FlashMessengerRendererFactory::class,
            $this->config['dependencies']['factories'][FlashMessengerRenderer::class]
        );
    }

    public function testDependenciesHasAliases(): void
    {
        $this->assertArrayHasKey('aliases', $this->config['dependencies']);
        $this->assertSame(
            FlashMessenger::class,
            $this->config['dependencies']['aliases'][FlashMessengerInterface::class]
        );
        $this->assertSame(
            FlashMessengerRenderer::class,
            $this->config['dependencies']['aliases'][RendererInterface::class]
        );
        $this->assertSame(
            FlashMessenger::class,
            $this->config['dependencies']['aliases']['FlashMessenger']
        );
    }
}
