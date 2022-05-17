<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\LogicException;
use Chubbyphp\DecodeEncode\RuntimeException;

final class Decoder implements DecoderInterface
{
    /**
     * @var array<string, TypeDecoderInterface>
     */
    private array $decoderTypes;

    /**
     * @param array<int, TypeDecoderInterface> $decoderTypes
     */
    public function __construct(array $decoderTypes)
    {
        $this->decoderTypes = [];
        foreach ($decoderTypes as $decoderType) {
            $this->addTypeDecoder($decoderType);
        }
    }

    /**
     * @return array<int, string>
     */
    public function getContentTypes(): array
    {
        return array_keys($this->decoderTypes);
    }

    /**
     * @throws LogicException
     * @throws RuntimeException
     *
     * @return array<string, null|array|bool|float|int|string>
     */
    public function decode(string $data, string $contentType): array
    {
        if (isset($this->decoderTypes[$contentType])) {
            return $this->decoderTypes[$contentType]->decode($data);
        }

        throw LogicException::createMissingContentType($contentType);
    }

    private function addTypeDecoder(TypeDecoderInterface $decoderType): void
    {
        $this->decoderTypes[$decoderType->getContentType()] = $decoderType;
    }
}
