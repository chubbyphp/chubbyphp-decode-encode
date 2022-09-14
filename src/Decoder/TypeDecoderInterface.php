<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\RuntimeException;

interface TypeDecoderInterface
{
    public function getContentType(): string;

    /**
     * @return array<string, null|array|bool|float|int|string>
     *
     * @throws RuntimeException
     */
    public function decode(string $data): array;
}
