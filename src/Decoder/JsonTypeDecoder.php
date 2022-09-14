<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\RuntimeException;

final class JsonTypeDecoder implements TypeDecoderInterface
{
    public function getContentType(): string
    {
        return 'application/json';
    }

    /**
     * @return array<string, null|array|bool|float|int|string>
     *
     * @throws RuntimeException
     */
    public function decode(string $data): array
    {
        try {
            $decoded = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            throw RuntimeException::createNotParsable($this->getContentType(), $e->getMessage());
        }

        if (!\is_array($decoded)) {
            throw RuntimeException::createNotParsable($this->getContentType(), 'Not an object');
        }

        return $decoded;
    }
}
