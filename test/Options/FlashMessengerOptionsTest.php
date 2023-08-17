<?php

declare(strict_types=1);

namespace DotTest\FlashMessenger\Options;

use Dot\FlashMessenger\Options\FlashMessengerOptions;
use PHPUnit\Framework\TestCase;

class FlashMessengerOptionsTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $options = ['testKey' => 'testValue'];
        $subject = new FlashMessengerOptions();

        $subject->setOptions($options);
        $this->assertSame($options, $subject->getOptions());
        $this->assertArrayHasKey('testKey', $subject->getOptions());
    }
}
