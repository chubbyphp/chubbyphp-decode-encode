<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\ServiceFactory;

use Chubbyphp\DecodeEncode\Encoder\EncoderInterface;
use Chubbyphp\DecodeEncode\Encoder\TypeEncoderInterface;
use Chubbyphp\DecodeEncode\ServiceFactory\EncoderFactory;
use Chubbyphp\Mock\MockMethod\WithReturn;
use Chubbyphp\Mock\MockObjectBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\DecodeEncode\ServiceFactory\EncoderFactory
 *
 * @internal
 */
final class EncoderFactoryTest extends TestCase
{
    public function testInvoke(): void
    {
        $builder = new MockObjectBuilder();

        /** @var ContainerInterface $container */
        $container = $builder->create(ContainerInterface::class, [
            new WithReturn('get', [TypeEncoderInterface::class.'[]'], []),
        ]);

        $factory = new EncoderFactory();

        $service = $factory($container);

        self::assertInstanceOf(EncoderInterface::class, $service);
    }

    public function testCallStatic(): void
    {
        $builder = new MockObjectBuilder();

        /** @var ContainerInterface $container */
        $container = $builder->create(ContainerInterface::class, [
            new WithReturn('get', [TypeEncoderInterface::class.'[]default'], []),
        ]);

        $factory = [EncoderFactory::class, 'default'];

        $service = $factory($container);

        self::assertInstanceOf(EncoderInterface::class, $service);
    }
}
