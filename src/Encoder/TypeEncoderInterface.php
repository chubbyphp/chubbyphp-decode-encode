<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

use Chubbyphp\DecodeEncode\RuntimeException;

interface TypeEncoderInterface
{
    public function getContentType(): string;

    /**
     * @param array<string, mixed> $data
     *
     * @throws RuntimeException
     */
    public function encode(array $data): string;
}
