<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Decoder;

use Chubbyphp\DecodeEncode\Decoder\Decoder;
use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\DecodeEncode\LogicException;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Decoder\Decoder
 *
 * @internal
 */
final class DecoderTest extends TestCase
{
    use MockByCallsTrait;

    public function testGetContentTypes(): void
    {
        /** @var MockObject|TypeDecoderInterface */
        $typeDecoder = $this->getMockByCalls(TypeDecoderInterface::class, [
            Call::create('getContentType')->with()->willReturn('application/json'),
        ]);

        $decoder = new Decoder([$typeDecoder]);

        self::assertSame(['application/json'], $decoder->getContentTypes());
    }

    public function testDecode(): void
    {
        /** @var MockObject|TypeDecoderInterface */
        $typeDecoder = $this->getMockByCalls(TypeDecoderInterface::class, [
            Call::create('getContentType')->with()->willReturn('application/json'),
            Call::create('decode')->with('{"key": "value"}')->willReturn(['key' => 'value']),
        ]);

        $decoder = new Decoder([$typeDecoder]);

        self::assertSame(['key' => 'value'], $decoder->decode('{"key": "value"}', 'application/json'));
    }

    public function testDecodeWithMissingType(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('There is no decoder/encoder for content-type: "application/xml"');

        /** @var MockObject|TypeDecoderInterface */
        $typeDecoder = $this->getMockByCalls(TypeDecoderInterface::class, [
            Call::create('getContentType')->with()->willReturn('application/json'),
        ]);

        $decoder = new Decoder([$typeDecoder]);

        $decoder->decode('<key>value</key>', 'application/xml');
    }
}
