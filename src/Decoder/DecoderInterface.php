<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\LogicException;
use Chubbyphp\DecodeEncode\RuntimeException;

interface DecoderInterface
{
    /**
     * @return array<int, string>
     */
    public function getContentTypes(): array;

    /**
     * @throws LogicException
     * @throws RuntimeException
     *
     * @return array<string, null|array|bool|float|int|string>
     */
    public function decode(string $data, string $contentType): array;
}
