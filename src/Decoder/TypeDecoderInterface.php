<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\RuntimeException;

interface TypeDecoderInterface
{
    public function getContentType(): string;

    /**
     * @return array<string, mixed>
     *
     * @throws RuntimeException
     */
    public function decode(string $data): array;
}
