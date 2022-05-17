<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Encoder;

use Chubbyphp\DecodeEncode\Encoder\Encoder;
use Chubbyphp\DecodeEncode\Encoder\TypeEncoderInterface;
use Chubbyphp\DecodeEncode\LogicException;
use Chubbyphp\Mock\Call;
use Chubbyphp\Mock\MockByCallsTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Encoder\Encoder
 *
 * @internal
 */
final class EncoderTest extends TestCase
{
    use MockByCallsTrait;

    public function testGetContentTypes(): void
    {
        /** @var MockObject|TypeEncoderInterface $typeEncoder */
        $typeEncoder = $this->getMockByCalls(TypeEncoderInterface::class, [
            Call::create('getContentType')->with()->willReturn('application/json'),
        ]);

        $encoder = new Encoder([$typeEncoder]);

        self::assertSame(['application/json'], $encoder->getContentTypes());
    }

    public function testEncode(): void
    {
        /** @var MockObject|TypeEncoderInterface $typeEncoder */
        $typeEncoder = $this->getMockByCalls(TypeEncoderInterface::class, [
            Call::create('getContentType')->with()->willReturn('application/json'),
            Call::create('encode')->with(['key' => 'value'])->willReturn('{"key":"value"}'),
        ]);

        $encoder = new Encoder([$typeEncoder]);

        self::assertSame('{"key":"value"}', $encoder->encode(['key' => 'value'], 'application/json'));
    }

    public function testEncodeWithMissingType(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('There is no decoder/encoder for content-type: "application/xml"');

        /** @var MockObject|TypeEncoderInterface $typeEncoder */
        $typeEncoder = $this->getMockByCalls(TypeEncoderInterface::class, [
            Call::create('getContentType')->with()->willReturn('application/json'),
        ]);

        $encoder = new Encoder([$typeEncoder]);

        $encoder->encode(['key' => 'value'], 'application/xml');
    }
}
