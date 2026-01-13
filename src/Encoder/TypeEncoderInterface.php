<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

interface TypeEncoderInterface
{
    public function getContentType(): string;

    /**
     * @param array<string, mixed> $data
     */
    public function encode(array $data): string;
}
