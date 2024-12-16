<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode;

final class LogicException extends \LogicException
{
    public static function createMissingContentType(string $contentType): self
    {
        return new self(\sprintf('There is no decoder/encoder for content-type: "%s"', $contentType));
    }
}
