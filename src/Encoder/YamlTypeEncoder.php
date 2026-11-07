<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

use Symfony\Component\Yaml\Yaml;

final class YamlTypeEncoder implements TypeEncoderInterface
{
    public function __construct(private readonly string $contentType = 'application/x-yaml') {}

    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function encode(array $data): string
    {
        return trim(Yaml::dump($data, 10, 4));
    }
}
