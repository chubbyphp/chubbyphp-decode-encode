<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\RuntimeException;

final class UrlEncodedTypeDecoder implements TypeDecoderInterface
{
    public function getContentType(): string
    {
        return 'application/x-www-form-urlencoded';
    }

    /**
     * @return array<string, mixed>
     *
     * @throws RuntimeException
     */
    public function decode(string $data): array
    {
        /** @var array<string, mixed> $rawData */
        $rawData = [];
        parse_str($data, $rawData);

        if ('' !== $data && [] === $rawData) {
            throw RuntimeException::createNotParsable($this->getContentType());
        }

        /** @var array<string, mixed> */
        return $this->fixValues($rawData);
    }

    /**
     * @param array<int|string, mixed> $rawData
     *
     * @return array<int|string, mixed>
     */
    private function fixValues(array $rawData): array
    {
        $data = [];
        foreach ($rawData as $key => $value) {
            if (\is_array($value)) {
                $data[$key] = $this->fixValues($value);
            } elseif (\is_string($value)) {
                $data[$key] = $this->fixValue($value);
            }
        }

        return $data;
    }

    private function fixValue(string $value): bool|float|int|string
    {
        if ('true' === $value) {
            return true;
        }

        if ('false' === $value) {
            return false;
        }

        if (is_numeric($value) && '0' !== $value[0]) {
            if ((string) (int) $value === $value) {
                return (int) $value;
            }

            return (float) $value;
        }

        return $value;
    }
}
