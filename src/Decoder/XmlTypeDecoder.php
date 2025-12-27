<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

final class XmlTypeDecoder implements TypeDecoderInterface
{
    private readonly JsonxTypeDecoder $jsonxTypeDecoder;

    public function __construct()
    {
        $this->jsonxTypeDecoder = new JsonxTypeDecoder();
    }

    public function getContentType(): string
    {
        return 'application/xml';
    }

    /**
     * @return array<string, null|array|bool|float|int|string>
     */
    public function decode(string $data): array
    {
        return $this->jsonxTypeDecoder->decode($data);
    }
}
