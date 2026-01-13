<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\RuntimeException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

final class YamlTypeDecoder implements TypeDecoderInterface
{
    public function getContentType(): string
    {
        return 'application/x-yaml';
    }

    /**
     * @return array<string, mixed>
     *
     * @throws RuntimeException
     */
    public function decode(string $data): array
    {
        try {
            $decoded = Yaml::parse($data);
        } catch (ParseException) {
            throw RuntimeException::createNotParsable($this->getContentType());
        }

        if (!\is_array($decoded)) {
            throw RuntimeException::createNotParsable($this->getContentType(), 'Not an object');
        }

        /** @var array<string, mixed> $decoded */

        return $decoded;
    }
}
