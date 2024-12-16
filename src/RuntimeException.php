<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode;

final class RuntimeException extends \RuntimeException
{
    public static function createNotParsable(string $contentType, ?string $error = null): self
    {
        $message = \sprintf('Data is not parsable with content-type: "%s"', $contentType);
        if (null !== $error) {
            $message .= \sprintf(', error: "%s"', $error);
        }

        return new self($message);
    }
}
