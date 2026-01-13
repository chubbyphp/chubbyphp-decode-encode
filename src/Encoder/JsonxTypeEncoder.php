<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Encoder;

/**
 * @see https://www.ibm.com/support/knowledgecenter/SS9H2Y_7.6.0/com.ibm.dp.doc/json_jsonx.html
 */
final class JsonxTypeEncoder implements TypeEncoderInterface
{
    public const string DATATYPE_OBJECT = 'object';
    public const string DATATYPE_ARRAY = 'array';
    public const string DATATYPE_BOOLEAN = 'boolean';
    public const string DATATYPE_STRING = 'string';
    public const string DATATYPE_NUMBER = 'number';
    public const string DATATYPE_NULL = 'null';

    public function __construct(private readonly bool $prettyPrint = false) {}

    public function getContentType(): string
    {
        return 'application/jsonx+xml';
    }

    /**
     * @param array<string, mixed> $data
     */
    public function encode(array $data): string
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $document->formatOutput = $this->prettyPrint;

        if (self::DATATYPE_OBJECT === $this->getType($data)) {
            /** @var array<string, mixed> $data */
            $rootNode = $this->createObjectNode($document, $data);
        } else {
            /** @var array<int, mixed> $data */
            $rootNode = $this->createArrayNode($document, $data);
        }

        $rootNode->setAttribute('xsi:schemaLocation', 'http://www.datapower.com/schemas/json jsonx.xsd');
        $rootNode->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $rootNode->setAttribute('xmlns:json', 'http://www.ibm.com/xmlns/prod/2009/jsonx');

        $document->appendChild($rootNode);

        return trim((string) $document->saveXML($document));
    }

    /**
     * @param array<string, mixed> $value
     */
    private function createObjectNode(\DOMDocument $document, array $value, ?string $name = null): \DOMElement
    {
        $node = $document->createElement('json:object');

        if (null !== $name) {
            $node->setAttribute('name', $name);
        }

        foreach ($value as $subName => $subValue) {
            $node->appendChild($this->createObjectPropertyNode($document, $subName, $subValue));
        }

        return $node;
    }

    private function createObjectPropertyNode(\DOMDocument $document, int|string $subName, mixed $subValue): \DOMElement
    {
        $subValueType = $this->getType($subValue);

        if (self::DATATYPE_OBJECT === $subValueType) {
            /** @var array<string, mixed> $subValue */
            return $this->createObjectNode($document, $subValue, (string) $subName);
        }

        if (self::DATATYPE_ARRAY === $subValueType) {
            /** @var array<int, mixed> $subValue */
            return $this->createArrayNode($document, $subValue, (string) $subName);
        }

        if (self::DATATYPE_BOOLEAN === $subValueType) {
            /** @var bool $subValue */
            return $this->createBooleanNode($document, $subValue, (string) $subName);
        }

        if (self::DATATYPE_STRING === $subValueType) {
            /** @var string $subValue */
            return $this->createStringNode($document, $subValue, (string) $subName);
        }

        if (self::DATATYPE_NUMBER === $subValueType) {
            /** @var float|int $subValue */
            return $this->createNumberNode($document, $subValue, (string) $subName);
        }

        return $this->createNullNode($document, (string) $subName);
    }

    /**
     * @param array<int, mixed> $value
     */
    private function createArrayNode(\DOMDocument $document, array $value, ?string $name = null): \DOMElement
    {
        $node = $document->createElement('json:array');

        if (null !== $name) {
            $node->setAttribute('name', $name);
        }

        foreach ($value as $subValue) {
            $node->appendChild($this->createArrayValueNode($document, $subValue));
        }

        return $node;
    }

    private function createArrayValueNode(\DOMDocument $document, mixed $subValue): \DOMElement
    {
        $subValueType = $this->getType($subValue);

        if (self::DATATYPE_OBJECT === $subValueType) {
            /** @var array<string, mixed> $subValue */
            return $this->createObjectNode($document, $subValue);
        }

        if (self::DATATYPE_ARRAY === $subValueType) {
            /** @var array<int, mixed> $subValue */
            return $this->createArrayNode($document, $subValue);
        }

        if (self::DATATYPE_BOOLEAN === $subValueType) {
            /** @var bool $subValue */
            return $this->createBooleanNode($document, $subValue);
        }

        if (self::DATATYPE_STRING === $subValueType) {
            /** @var string $subValue */
            return $this->createStringNode($document, $subValue);
        }

        if (self::DATATYPE_NUMBER === $subValueType) {
            /** @var float|int $subValue */
            return $this->createNumberNode($document, $subValue);
        }

        return $this->createNullNode($document);
    }

    private function createBooleanNode(\DOMDocument $document, bool $value, ?string $name = null): \DOMElement
    {
        $node = $document->createElement('json:boolean', $value ? 'true' : 'false');

        if (null !== $name) {
            $node->setAttribute('name', $name);
        }

        return $node;
    }

    private function createStringNode(\DOMDocument $document, string $value, ?string $name = null): \DOMElement
    {
        $node = $document->createElement('json:string', htmlentities($value, ENT_COMPAT | ENT_XML1, 'UTF-8'));

        if (null !== $name) {
            $node->setAttribute('name', $name);
        }

        return $node;
    }

    private function createNumberNode(\DOMDocument $document, float|int $value, ?string $name = null): \DOMElement
    {
        $node = $document->createElement('json:number', (string) $value);

        if (null !== $name) {
            $node->setAttribute('name', $name);
        }

        return $node;
    }

    private function createNullNode(\DOMDocument $document, ?string $name = null): \DOMElement
    {
        $node = $document->createElement('json:null');

        if (null !== $name) {
            $node->setAttribute('name', $name);
        }

        return $node;
    }

    private function getType(mixed $value): string
    {
        if (\is_array($value)) {
            if ($value !== array_values($value)) {
                return self::DATATYPE_OBJECT;
            }

            return self::DATATYPE_ARRAY;
        }

        if (\is_bool($value)) {
            return self::DATATYPE_BOOLEAN;
        }

        if (\is_string($value)) {
            return self::DATATYPE_STRING;
        }

        if (\is_int($value) || \is_float($value)) {
            return self::DATATYPE_NUMBER;
        }

        if (null === $value) {
            return self::DATATYPE_NULL;
        }

        throw new \InvalidArgumentException(\sprintf('Unsupported data type: %s', \gettype($value)));
    }
}
