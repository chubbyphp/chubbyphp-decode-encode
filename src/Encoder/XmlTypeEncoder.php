<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

final class XmlTypeEncoder implements TypeEncoderInterface
{
    private readonly JsonxTypeEncoder $jsonxTypeEncoder;

    public function __construct(bool $prettyPrint = false)
    {
        $this->jsonxTypeEncoder = new JsonxTypeEncoder($prettyPrint);
    }

    public function getContentType(): string
    {
        return 'application/xml';
    }

    /**
     * @param array<string, mixed> $data
     */
    public function encode(array $data): string
    {
        return $this->jsonxTypeEncoder->encode($data);
    }
}
