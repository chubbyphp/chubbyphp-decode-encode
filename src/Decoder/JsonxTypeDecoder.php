<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\Decoder;

use Chubbyphp\DecodeEncode\RuntimeException;

/**
 * @see https://www.ibm.com/support/knowledgecenter/SS9H2Y_7.6.0/com.ibm.dp.doc/json_jsonx.html
 */
final class JsonxTypeDecoder implements TypeDecoderInterface
{
    private const string DATATYPE_OBJECT = 'object';
    private const string DATATYPE_ARRAY = 'array';
    private const string DATATYPE_BOOLEAN = 'boolean';
    private const string DATATYPE_STRING = 'string';
    private const string DATATYPE_NUMBER = 'number';
    private const string DATATYPE_NULL = 'null';

    public function getContentType(): string
    {
        return 'application/jsonx+xml';
    }

    /**
     * @return array<string, mixed>
     *
     * @throws RuntimeException
     */
    public function decode(string $data): array
    {
        $document = new \DOMDocument();

        @$document->loadXML($data);

        $documentElement = $document->documentElement;

        if (null === $documentElement) {
            throw RuntimeException::createNotParsable($this->getContentType());
        }

        $result = $this->decodeNode($documentElement);

        if (!\is_array($result)) {
            throw RuntimeException::createNotParsable($this->getContentType());
        }

        /** @var array<string, mixed> $result */

        return $result;
    }

    /**
     * @return null|array<mixed>|bool|float|int|string
     */
    private function decodeNode(\DOMElement $node): array|bool|float|int|string|null
    {
        $nodeName = $node->nodeName;

        $nodeType = substr($nodeName, 5);

        if (self::DATATYPE_OBJECT === $nodeType) {
            return $this->decodeObjectNode($node);
        }

        if (self::DATATYPE_ARRAY === $nodeType) {
            return $this->decodeArrayNode($node);
        }

        if (self::DATATYPE_BOOLEAN === $nodeType) {
            return $this->decodeBooleanNode($node);
        }

        if (self::DATATYPE_STRING === $nodeType) {
            return $this->decodeStringNode($node);
        }

        if (self::DATATYPE_NUMBER === $nodeType) {
            return $this->decodeNumberNode($node);
        }

        if (self::DATATYPE_NULL === $nodeType) {
            return null;
        }

        throw RuntimeException::createNotParsable($this->getContentType());
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeObjectNode(\DOMElement $node): array
    {
        $data = [];
        foreach ($node->childNodes as $childNode) {
            if (!$childNode instanceof \DOMElement) {
                continue;
            }

            $data[$childNode->getAttribute('name')] = $this->decodeNode($childNode);
        }

        return $data;
    }

    /**
     * @return array<int, mixed>
     */
    private function decodeArrayNode(\DOMElement $node): array
    {
        $data = [];
        foreach ($node->childNodes as $childNode) {
            if (!$childNode instanceof \DOMElement) {
                continue;
            }

            $data[] = $this->decodeNode($childNode);
        }

        return $data;
    }

    private function decodeBooleanNode(\DOMElement $node): bool
    {
        return 'true' === $node->nodeValue;
    }

    private function decodeStringNode(\DOMElement $node): string
    {
        return $node->nodeValue ?? '';
    }

    private function decodeNumberNode(\DOMElement $node): float|int
    {
        $value = $node->nodeValue ?? '0';

        if ($value === (string) (int) $value) {
            return (int) $value;
        }

        return (float) $value;
    }
}
