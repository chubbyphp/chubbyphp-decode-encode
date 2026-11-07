<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\ServiceFactory;

use Chubbyphp\DecodeEncode\Decoder\JsonTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\JsonxTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\NdjsonTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\DecodeEncode\Decoder\UrlEncodedTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\YamlTypeDecoder;
use Chubbyphp\DecodeEncode\ServiceFactory\TypeDecodersFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\ServiceFactory\TypeDecodersFactory
 *
 * @internal
 */
final class TypeDecodersFactoryTest extends TestCase
{
    public function testInvoke(): void
    {
        $factory = new TypeDecodersFactory();

        $typeDecoders = $factory();

        self::assertIsArray($typeDecoders);

        self::assertCount(10, $typeDecoders);

        self::assertSame([
            JsonTypeDecoder::class,
            JsonxTypeDecoder::class,
            NdjsonTypeDecoder::class,
            NdjsonTypeDecoder::class,
            NdjsonTypeDecoder::class,
            NdjsonTypeDecoder::class,
            NdjsonTypeDecoder::class,
            UrlEncodedTypeDecoder::class,
            YamlTypeDecoder::class,
            YamlTypeDecoder::class,
        ], array_map(static fn (TypeDecoderInterface $typeDecoder) => $typeDecoder::class, $typeDecoders));

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
        ], array_map(static fn (TypeDecoderInterface $typeDecoder) => $typeDecoder->getContentType(), $typeDecoders));
    }
}
