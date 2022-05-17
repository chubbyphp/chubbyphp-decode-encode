<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

use Chubbyphp\DecodeEncode\LogicException;

interface EncoderInterface
{
    /**
     * @return array<int, string>
     */
    public function getContentTypes(): array;

    /**
     * @param array<string, null|array|bool|float|int|string> $data
     *
     * @throws LogicException
     */
    public function encode(array $data, string $contentType): string;
}
