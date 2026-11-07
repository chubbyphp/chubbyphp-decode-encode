<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Decoder;

use Chubbyphp\DecodeEncode\Decoder\NdjsonTypeDecoder;
use Chubbyphp\DecodeEncode\RuntimeException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Decoder\NdjsonTypeDecoder
 *
 * @internal
 */
final class NdjsonTypeDecoderTest extends TestCase
{
    public function testGetContentType(): void
    {
        $decoder = new NdjsonTypeDecoder();

        self::assertSame('application/jsonl', $decoder->getContentType());
    }

    #[DataProviderExternal(TypeDecoderDataProvider::class, 'getExpectedData')]
    public function testDecode(array $expectedData): void
    {
        $line = json_encode($expectedData, JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR);

        $decoder = new NdjsonTypeDecoder();

        self::assertSame([$expectedData, $expectedData], $decoder->decode($line."\n".$line."\n"));
    }

    public function testDecodeScalarsArraysAndNullWithoutTrailingLineTerminator(): void
    {
        $decoder = new NdjsonTypeDecoder();

        self::assertSame(
            [1, 'value', true, null, [1, 2], ['key' => 'value']],
            $decoder->decode("1\n\"value\"\ntrue\nnull\n[1,2]\n{\"key\":\"value\"}")
        );
    }

    public function testDecodeEmpty(): void
    {
        $decoder = new NdjsonTypeDecoder();

        self::assertSame([], $decoder->decode(''));
    }

    public function testDecodeCrlfLineEndingsAndSurroundingWhitespace(): void
    {
        $decoder = new NdjsonTypeDecoder();

        self::assertSame([['a' => 1], ['b' => 2]], $decoder->decode("{\"a\":1}\r\n {\"b\":2} \r\n"));
    }

    #[DataProvider('provideDecodeEmptyLineCases')]
    public function testDecodeEmptyLine(string $data, int $line): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            \sprintf('Data is not parsable with content-type: "application/jsonl", error: "Line %d: Empty line"', $line)
        );

        $decoder = new NdjsonTypeDecoder();
        $decoder->decode($data);
    }

    public static function provideDecodeEmptyLineCases(): iterable
    {
        yield 'only line terminator' => ["\n", 1];

        yield 'only crlf line terminator' => ["\r\n", 1];

        yield 'empty line in between' => ["{\"a\":1}\n\n{\"b\":2}\n", 2];

        yield 'empty line at the end' => ["{\"a\":1}\n\n", 2];

        yield 'empty crlf line at the end' => ["{\"a\":1}\n\r\n", 2];

        yield 'spaces only line' => ["{\"a\":1}\n   \n", 2];

        yield 'tab only line without line terminator' => ["{\"a\":1}\n\t", 2];
    }

    public function testDecodeIgnoreEmptyLines(): void
    {
        $decoder = new NdjsonTypeDecoder('application/x-ndjson', true);

        self::assertSame(
            [['a' => 1], ['b' => 2]],
            $decoder->decode("\n{\"a\":1}\r\n\r\n   \n\t\n{\"b\":2}\n\n")
        );
    }

    #[DataProvider('provideDecodeNonJsonWhitespaceOnlyLineIsNotAnEmptyLineCases')]
    public function testDecodeNonJsonWhitespaceOnlyLineIsNotAnEmptyLine(string $whitespace, string $error): void
    {
        foreach ([new NdjsonTypeDecoder(), new NdjsonTypeDecoder('application/jsonl', true)] as $decoder) {
            try {
                $decoder->decode("{\"a\":1}\n".$whitespace."\n{\"b\":2}\n");

                self::fail('Expected exception');
            } catch (RuntimeException $e) {
                self::assertSame(
                    \sprintf('Data is not parsable with content-type: "application/jsonl", error: "Line 2: %s"', $error),
                    $e->getMessage()
                );
            }
        }
    }

    public static function provideDecodeNonJsonWhitespaceOnlyLineIsNotAnEmptyLineCases(): iterable
    {
        yield 'byte order mark' => ["\u{FEFF}", 'Syntax error'];

        yield 'non-breaking space' => ["\u{00A0}", 'Syntax error'];

        yield 'vertical tab' => ["\v", 'Control character error, possibly incorrectly encoded'];

        yield 'form feed' => ["\f", 'Control character error, possibly incorrectly encoded'];

        yield 'null byte' => ["\0", 'Control character error, possibly incorrectly encoded'];

        yield 'line separator' => ["\u{2028}", 'Syntax error'];
    }

    public function testDecodePrettyPrintedJsonIsNotNdjson(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Data is not parsable with content-type: "application/jsonl", error: "Line 1: Syntax error"');

        $decoder = new NdjsonTypeDecoder();
        $decoder->decode("{\n\"key\":\"value\"\n}");
    }

    public function testDecodeByteOrderMark(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Data is not parsable with content-type: "application/jsonl", error: "Line 1: Syntax error"');

        $decoder = new NdjsonTypeDecoder();
        $decoder->decode("\u{FEFF}{\"a\":1}\n");
    }

    public function testDecodeSyntaxErrorWithLineNumber(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Data is not parsable with content-type: "application/jsonl", error: "Line 3: Syntax error"');

        $decoder = new NdjsonTypeDecoder();
        $decoder->decode("{\"a\":1}\n{\"b\":2}\n{\"c\":");
    }

    public function testDecodeMaxNested(): void
    {
        $data = [];
        for ($i = 0; $i < 510; ++$i) {
            $data = ['data' => $data];
        }

        $decoder = new NdjsonTypeDecoder();

        self::assertSame([$data], $decoder->decode(json_encode($data, 0, 511)."\n"));
    }

    public function testDecodeToMuchNested(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Data is not parsable with content-type: "application/jsonl", error: "Line 1: Maximum stack depth exceeded"');

        $data = [];
        for ($i = 0; $i < 511; ++$i) {
            $data = ['data' => $data];
        }

        $decoder = new NdjsonTypeDecoder();
        $decoder->decode(json_encode($data, 0, 512)."\n");
    }

    public function testWithCustomContentType(): void
    {
        $decoder = new NdjsonTypeDecoder('application/x-ndjson');

        self::assertSame('application/x-ndjson', $decoder->getContentType());

        self::assertSame([['a' => 1], ['b' => 2]], $decoder->decode("{\"a\":1}\n{\"b\":2}\n"));
    }

    public function testInvalidDecodeWithCustomContentType(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Data is not parsable with content-type: "application/x-ndjson", error: "Line 1: Empty line"');

        $decoder = new NdjsonTypeDecoder('application/x-ndjson');
        $decoder->decode("\n");
    }
}
