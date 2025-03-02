<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Encoder;

use Chubbyphp\DecodeEncode\Encoder\Encoder;
use Chubbyphp\DecodeEncode\Encoder\TypeEncoderInterface;
use Chubbyphp\DecodeEncode\LogicException;
use Chubbyphp\Mock\MockMethod\WithReturn;
use Chubbyphp\Mock\MockObjectBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Encoder\Encoder
 *
 * @internal
 */
final class EncoderTest extends TestCase
{
    public function testGetContentTypes(): void
    {
        $builder = new MockObjectBuilder();

        /** @var TypeEncoderInterface $typeEncoder */
        $typeEncoder = $builder->create(TypeEncoderInterface::class, [
            new WithReturn('getContentType', [], 'application/json'),
        ]);

        $encoder = new Encoder([$typeEncoder]);

        self::assertSame(['application/json'], $encoder->getContentTypes());
    }

    public function testEncode(): void
    {
        $builder = new MockObjectBuilder();

        /** @var TypeEncoderInterface $typeEncoder */
        $typeEncoder = $builder->create(TypeEncoderInterface::class, [
            new WithReturn('getContentType', [], 'application/json'),
            new WithReturn('encode', [['key' => 'value']], '{"key":"value"}'),
        ]);

        $encoder = new Encoder([$typeEncoder]);

        self::assertSame('{"key":"value"}', $encoder->encode(['key' => 'value'], 'application/json'));
    }

    public function testEncodeWithMissingType(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('There is no decoder/encoder for content-type: "application/xml"');

        $builder = new MockObjectBuilder();

        /** @var TypeEncoderInterface $typeEncoder */
        $typeEncoder = $builder->create(TypeEncoderInterface::class, [
            new WithReturn('getContentType', [], 'application/json'),
        ]);

        $encoder = new Encoder([$typeEncoder]);

        $encoder->encode(['key' => 'value'], 'application/xml');
    }
}
