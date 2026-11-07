<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\ServiceFactory;

use Chubbyphp\DecodeEncode\Decoder\JsonTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\JsonxTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\NdjsonTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\DecodeEncode\Decoder\UrlEncodedTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\YamlTypeDecoder;

final class TypeDecodersFactory
{
    /**
     * @return list<TypeDecoderInterface>
     */
    public function __invoke(): array
    {
        return [
            new JsonTypeDecoder(),
            new JsonxTypeDecoder(),
            new NdjsonTypeDecoder(),
            new NdjsonTypeDecoder('application/x-jsonl'),
            new NdjsonTypeDecoder('text/jsonl'),
            new NdjsonTypeDecoder('application/ndjson'),
            new NdjsonTypeDecoder('application/x-ndjson'),
            new UrlEncodedTypeDecoder(),
            new YamlTypeDecoder(),
            new YamlTypeDecoder('application/yaml'),
        ];
    }
}
