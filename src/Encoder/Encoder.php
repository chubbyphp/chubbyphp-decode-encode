<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

use Chubbyphp\DecodeEncode\LogicException;

final class Encoder implements EncoderInterface
{
    /**
     * @var array<string, TypeEncoderInterface>
     */
    private array $encoderTypes = [];

    /**
     * @param array<int, TypeEncoderInterface> $encoderTypes
     */
    public function __construct(array $encoderTypes)
    {
        foreach ($encoderTypes as $encoderType) {
            $this->addTypeEncoder($encoderType);
        }
    }

    /**
     * @return array<int, string>
     */
    public function getContentTypes(): array
    {
        return array_keys($this->encoderTypes);
    }

    /**
     * @param array<string, null|array|bool|float|int|string> $data
     *
     * @throws LogicException
     */
    public function encode(array $data, string $contentType): string
    {
        if (isset($this->encoderTypes[$contentType])) {
            return $this->encoderTypes[$contentType]->encode($data);
        }

        throw LogicException::createMissingContentType($contentType);
    }

    private function addTypeEncoder(TypeEncoderInterface $encoderType): void
    {
        $this->encoderTypes[$encoderType->getContentType()] = $encoderType;
    }
}
