<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

final class JsonTypeEncoder implements TypeEncoderInterface
{
    public function __construct(private bool $prettyPrint = false) {}

    public function getContentType(): string
    {
        return 'application/json';
    }

    /**
     * @param array<string, null|array|bool|float|int|string> $data
     */
    public function encode(array $data): string
    {
        $options = JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE | JSON_THROW_ON_ERROR;
        if ($this->prettyPrint) {
            $options |= JSON_PRETTY_PRINT;
        }

        return json_encode($data, $options);
    }
}
