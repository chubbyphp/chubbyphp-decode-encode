<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\RuntimeException;

/**
 * @see https://jsonlines.org
 * @see https://github.com/ndjson/ndjson-spec
 */
final class NdjsonTypeDecoder implements TypeDecoderInterface
{
    public function __construct(
        private readonly string $contentType = 'application/jsonl',
        private readonly bool $ignoreEmptyLines = false,
    ) {}

    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * Returns a list with one entry per line.
     *
     * @return array<string, mixed>
     *
     * @throws RuntimeException
     */
    public function decode(string $data): array
    {
        $lines = explode("\n", $data);

        // the line terminator after the last line does not start another line
        if ('' === $lines[array_key_last($lines)]) {
            array_pop($lines);
        }

        /** @var array<mixed> $decoded */
        $decoded = [];
        foreach ($lines as $index => $line) {
            // only json whitespace (RFC 8259), "\n" is the line separator, trim() without characters would also strip "\0", "\v"
            if ('' === trim($line, " \t\r")) {
                if ($this->ignoreEmptyLines) {
                    continue;
                }

                throw RuntimeException::createNotParsable($this->contentType, \sprintf('Line %d: Empty line', $index + 1));
            }

            $decoded[] = $this->decodeLine($line, $index);
        }

        /** @var array<string, mixed> $decoded */

        return $decoded;
    }

    /**
     * @throws RuntimeException
     */
    private function decodeLine(string $line, int $index): mixed
    {
        try {
            return json_decode($line, true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw RuntimeException::createNotParsable(
                $this->contentType,
                \sprintf('Line %d: %s', $index + 1, $e->getMessage())
            );
        }
    }
}
