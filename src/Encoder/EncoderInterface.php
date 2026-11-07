<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

use Chubbyphp\DecodeEncode\LogicException;
use Chubbyphp\DecodeEncode\RuntimeException;

interface EncoderInterface
{
    /**
     * @return list<string>
     */
    public function getContentTypes(): array;

    /**
     * @param array<string, mixed> $data
     *
     * @throws LogicException
     * @throws RuntimeException
     */
    public function encode(array $data, string $contentType): string;
}
