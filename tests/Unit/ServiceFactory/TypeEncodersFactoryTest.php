<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\ServiceFactory;

use Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\JsonxTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\NdjsonTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\TypeEncoderInterface;
use Chubbyphp\DecodeEncode\Encoder\UrlEncodedTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\YamlTypeEncoder;
use Chubbyphp\DecodeEncode\ServiceFactory\TypeEncodersFactory;
use Chubbyphp\Mock\MockMethod\WithReturn;
use Chubbyphp\Mock\MockObjectBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @covers \Chubbyphp\DecodeEncode\ServiceFactory\TypeEncodersFactory
 *
 * @internal
 */
final class TypeEncodersFactoryTest extends TestCase
{
    public function testInvoke(): void
    {
        $builder = new MockObjectBuilder();

        /** @var ContainerInterface $container */
        $container = $builder->create(ContainerInterface::class, [
            new WithReturn('get', ['config'], ['debug' => true]),
        ]);

        $factory = new TypeEncodersFactory();

        $typeEncoders = $factory($container);

        self::assertIsArray($typeEncoders);

        self::assertCount(10, $typeEncoders);

        self::assertSame([
            JsonTypeEncoder::class,
            JsonxTypeEncoder::class,
            NdjsonTypeEncoder::class,
            NdjsonTypeEncoder::class,
            NdjsonTypeEncoder::class,
            NdjsonTypeEncoder::class,
            NdjsonTypeEncoder::class,
            UrlEncodedTypeEncoder::class,
            YamlTypeEncoder::class,
            YamlTypeEncoder::class,
        ], array_map(static fn (TypeEncoderInterface $typeEncoder) => $typeEncoder::class, $typeEncoders));

        self::assertSame([
            'application/json',
            'application/jsonx+xml',
            'application/jsonl',
            'application/x-jsonl',
            'text/jsonl',
            'application/ndjson',
            'application/x-ndjson',
            'application/x-www-form-urlencoded',
            'application/x-yaml',
            'application/yaml',
        ], array_map(static fn (TypeEncoderInterface $typeEncoder) => $typeEncoder->getContentType(), $typeEncoders));
    }
}
