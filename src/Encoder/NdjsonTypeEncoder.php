<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

use Chubbyphp\DecodeEncode\RuntimeException;

/**
 * @see https://jsonlines.org
 * @see https://github.com/ndjson/ndjson-spec
 */
final class NdjsonTypeEncoder implements TypeEncoderInterface
{
    public function __construct(private readonly string $contentType = 'application/jsonl') {}

    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * Expects a list, each entry gets encoded as one line.
     *
     * @param array<string, mixed> $data
     *
     * @throws RuntimeException
     */
    public function encode(array $data): string
    {
        return $this->encodeLines($data);
    }

    /**
     * @param array<mixed> $data
     *
     * @throws RuntimeException
     */
    private function encodeLines(array $data): string
    {
        if (!array_is_list($data)) {
            throw RuntimeException::createNotEncodable($this->contentType, 'Not a list');
        }

        $options = JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE | JSON_THROW_ON_ERROR;

        $encoded = '';
        foreach ($data as $item) {
            $encoded .= json_encode($item, $options)."\n";
        }

        return $encoded;
    }
}
