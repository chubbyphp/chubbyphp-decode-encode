<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Decoder;

use Chubbyphp\DecodeEncode\Decoder\Decoder;
use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\DecodeEncode\LogicException;
use Chubbyphp\Mock\MockMethod\WithReturn;
use Chubbyphp\Mock\MockObjectBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Decoder\Decoder
 *
 * @internal
 */
final class DecoderTest extends TestCase
{
    public function testGetContentTypes(): void
    {
        $builder = new MockObjectBuilder();

        /** @var TypeDecoderInterface $typeDecoder */
        $typeDecoder = $builder->create(TypeDecoderInterface::class, [
            new WithReturn('getContentType', [], 'application/json'),
        ]);

        $decoder = new Decoder([$typeDecoder]);

        self::assertSame(['application/json'], $decoder->getContentTypes());
    }

    public function testDecode(): void
    {
        $builder = new MockObjectBuilder();

        /** @var TypeDecoderInterface $typeDecoder */
        $typeDecoder = $builder->create(TypeDecoderInterface::class, [
            new WithReturn('getContentType', [], 'application/json'),
            new WithReturn('decode', ['{"key": "value"}'], ['key' => 'value']),
        ]);

        $decoder = new Decoder([$typeDecoder]);

        self::assertSame(['key' => 'value'], $decoder->decode('{"key": "value"}', 'application/json'));
    }

    public function testDecodeWithMissingType(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('There is no decoder/encoder for content-type: "application/xml"');

        $builder = new MockObjectBuilder();

        /** @var TypeDecoderInterface $typeDecoder */
        $typeDecoder = $builder->create(TypeDecoderInterface::class, [
            new WithReturn('getContentType', [], 'application/json'),
        ]);

        $decoder = new Decoder([$typeDecoder]);

        $decoder->decode('<key>value</key>', 'application/xml');
    }
}
