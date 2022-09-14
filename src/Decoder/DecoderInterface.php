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
     * @return array<string, null|array|bool|float|int|string>
     *
     * @throws LogicException
     * @throws RuntimeException
     */
    public function decode(string $data, string $contentType): array;
}
