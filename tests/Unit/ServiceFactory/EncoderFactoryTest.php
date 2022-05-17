<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\ServiceFactory;

use Chubbyphp\DecodeEncode\Encoder\EncoderInterface;
use Chubbyphp\DecodeEncode\Encoder\TypeEncoderInterface;
use Chubbyphp\DecodeEncode\ServiceFactory\EncoderFactory;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\DecodeEncode\ServiceFactory\EncoderFactory
 *
 * @internal
 */
final class EncoderFactoryTest extends TestCase
{
    use MockByCallsTrait;

    public function testInvoke(): void
    {
        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('get')->with(TypeEncoderInterface::class.'[]')->willReturn([]),
        ]);

        $factory = new EncoderFactory();

        $service = $factory($container);

        self::assertInstanceOf(EncoderInterface::class, $service);
    }

    public function testCallStatic(): void
    {
        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('get')->with(TypeEncoderInterface::class.'[]default')->willReturn([]),
        ]);

        $factory = [EncoderFactory::class, 'default'];

        $service = $factory($container);

        self::assertInstanceOf(EncoderInterface::class, $service);
    }
}
