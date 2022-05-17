<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit;

use Chubbyphp\DecodeEncode\LogicException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\LogicException
 *
 * @internal
 */
final class LogicExceptionTest extends TestCase
{
    public function testCreateMissingContentType(): void
    {
        $exception = LogicException::createMissingContentType('application/json');

        self::assertSame('There is no decoder/encoder for content-type: "application/json"', $exception->getMessage());
    }
}
