<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\ServiceFactory;

use Chubbyphp\DecodeEncode\Decoder\DecoderInterface;
use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\DecodeEncode\ServiceFactory\DecoderFactory;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\DecodeEncode\ServiceFactory\DecoderFactory
 *
 * @internal
 */
final class DecoderFactoryTest extends TestCase
{
    use MockByCallsTrait;

    public function testInvoke(): void
    {
        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('get')->with(TypeDecoderInterface::class.'[]')->willReturn([]),
        ]);

        $factory = new DecoderFactory();

        $service = $factory($container);

        self::assertInstanceOf(DecoderInterface::class, $service);
    }

    public function testCallStatic(): void
    {
        /** @var ContainerInterface $container */
        $container = $this->getMockByCalls(ContainerInterface::class, [
            Call::create('get')->with(TypeDecoderInterface::class.'[]default')->willReturn([]),
        ]);

        $factory = [DecoderFactory::class, 'default'];

        $service = $factory($container);

        self::assertInstanceOf(DecoderInterface::class, $service);
    }
}
