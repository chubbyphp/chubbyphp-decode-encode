<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit;

use Chubbyphp\DecodeEncode\RuntimeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\RuntimeException
 *
 * @internal
 */
final class RuntimeExceptionTest extends TestCase
{
    public function testCreateNotParsableWithoutError(): void
    {
        $exception = RuntimeException::createNotParsable('application/json');

        self::assertSame('Data is not parsable with content-type: "application/json"', $exception->getMessage());
    }

    public function testCreateNotParsableWithError(): void
    {
        $exception = RuntimeException::createNotParsable('application/json', 'unknown');

        self::assertSame(
            'Data is not parsable with content-type: "application/json", error: "unknown"',
            $exception->getMessage()
        );
    }

    public function testCreateNotEncodableWithoutError(): void
    {
        $exception = RuntimeException::createNotEncodable('application/jsonl');

        self::assertSame('Data is not encodable with content-type: "application/jsonl"', $exception->getMessage());
    }

    public function testCreateNotEncodableWithError(): void
    {
        $exception = RuntimeException::createNotEncodable('application/jsonl', 'Not a list');

        self::assertSame(
            'Data is not encodable with content-type: "application/jsonl", error: "Not a list"',
            $exception->getMessage()
        );
    }
}
