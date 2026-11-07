<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Encoder;

use Chubbyphp\DecodeEncode\Encoder\NdjsonTypeEncoder;
use Chubbyphp\DecodeEncode\RuntimeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Encoder\NdjsonTypeEncoder
 *
 * @internal
 */
final class NdjsonTypeEncoderTest extends TestCase
{
    public function testContentType(): void
    {
        $encoder = new NdjsonTypeEncoder();

        self::assertSame('application/jsonl', $encoder->getContentType());
    }

    #[DataProviderExternal(TypeEncoderDataProvider::class, 'getExpectedData')]
    public function testFormat(array $data): void
    {
        $encoder = new NdjsonTypeEncoder();

        $ndjson = $encoder->encode([$data, $data]);

        $lines = explode("\n", $ndjson);

        self::assertCount(3, $lines);
        self::assertSame('', $lines[2]);
        self::assertSame($data, json_decode($lines[0], true));
        self::assertSame($data, json_decode($lines[1], true));
    }

    public function testEncodeScalarsArraysAndNull(): void
    {
        $encoder = new NdjsonTypeEncoder();

        self::assertSame(
            "1\n\"value\"\ntrue\nnull\n[1,2]\n{\"key\":\"value\"}\n",
            $encoder->encode([1, 'value', true, null, [1, 2], ['key' => 'value']])
        );
    }

    public function testEncodeEscapesLineTerminatorsWithinStrings(): void
    {
        $encoder = new NdjsonTypeEncoder();

        self::assertSame(
            '{"key":"line1\nline2\r\u2028\u2029"}'."\n",
            $encoder->encode([['key' => "line1\nline2\r\u{2028}\u{2029}"]])
        );
    }

    public function testEncodeOptions(): void
    {
        $encoder = new NdjsonTypeEncoder();

        self::assertSame(
            '{"float":1.0,"unicode":"äöü","slashes":"a/b","invalidUtf8":"ab"}'."\n",
            $encoder->encode([['float' => 1.0, 'unicode' => 'äöü', 'slashes' => 'a/b', 'invalidUtf8' => "a\xB1b"]])
        );
    }

    public function testEncodeEmpty(): void
    {
        $encoder = new NdjsonTypeEncoder();

        self::assertSame('', $encoder->encode([]));
    }

    #[DataProvider('provideEncodeNotAListCases')]
    public function testEncodeNotAList(array $data): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Data is not encodable with content-type: "application/jsonl", error: "Not a list"');

        $encoder = new NdjsonTypeEncoder();
        $encoder->encode($data);
    }

    public static function provideEncodeNotAListCases(): iterable
    {
        yield 'map' => [['key' => 'value']];

        yield 'list with gap' => [[0 => 'a', 2 => 'b']];

        yield 'list not starting with 0' => [[1 => 'a']];
    }

    public function testEncodeInvalidValue(): void
    {
        $this->expectException(\JsonException::class);

        $encoder = new NdjsonTypeEncoder();
        $encoder->encode([NAN]);
    }

    public function testWithCustomContentType(): void
    {
        $encoder = new NdjsonTypeEncoder('application/x-ndjson');

        self::assertSame('application/x-ndjson', $encoder->getContentType());

        self::assertSame("{\"a\":1}\n{\"b\":2}\n", $encoder->encode([['a' => 1], ['b' => 2]]));
    }

    public function testNotAListWithCustomContentType(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Data is not encodable with content-type: "application/x-ndjson", error: "Not a list"');

        $encoder = new NdjsonTypeEncoder('application/x-ndjson');
        $encoder->encode(['key' => 'value']);
    }
}
