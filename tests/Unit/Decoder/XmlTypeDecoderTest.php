<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Decoder;

use Chubbyphp\DecodeEncode\Decoder\XmlTypeDecoder;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Decoder\XmlTypeDecoder
 *
 * @internal
 */
final class XmlTypeDecoderTest extends TestCase
{
    public function testGetContentType(): void
    {
        $decoder = new XmlTypeDecoder();

        self::assertSame('application/xml', $decoder->getContentType());
    }

    #[DataProviderExternal(TypeDecoderDataProvider::class, 'getExpectedData')]
    public function testDecode(array $expectedData): void
    {
        $xml = <<<'EOD'
            <?xml version="1.0" encoding="UTF-8"?>
            <json:object xsi:schemaLocation="http://www.datapower.com/schemas/json jsonx.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:json="http://www.ibm.com/xmlns/prod/2009/jsonx">
                <json:number name="page">1</json:number>
                <json:number name="perPage">10</json:number>
                <json:null name="search"/>
                <json:string name="sort">name</json:string>
                <json:string name="order">asc</json:string>
                <json:object name="_embedded">
                <json:object name="mainItem">
                    <json:string name="id">id1</json:string>
                    <json:string name="name">A fancy Name</json:string>
                    <json:object name="treeValues">
                    <json:object name="1">
                        <json:number name="2">3</json:number>
                    </json:object>
                    </json:object>
                    <json:number name="progress">76.8</json:number>
                    <json:boolean name="active">true</json:boolean>
                    <json:string name="_type">item</json:string>
                    <json:object name="_links">
                    <json:object name="read">
                        <json:string name="href">http://test.com/items/id1</json:string>
                        <json:string name="method">GET</json:string>
                    </json:object>
                    <json:object name="update">
                        <json:string name="href">http://test.com/items/id1</json:string>
                        <json:string name="method">PUT</json:string>
                    </json:object>
                    <json:object name="delete">
                        <json:string name="href">http://test.com/items/id1</json:string>
                        <json:string name="method">DELETE</json:string>
                    </json:object>
                    </json:object>
                </json:object>
                <json:array name="items">
                    <json:object>
                    <json:string name="id">id1</json:string>
                    <json:string name="name">A fancy Name</json:string>
                    <json:object name="treeValues">
                        <json:object name="1">
                        <json:number name="2">3</json:number>
                        </json:object>
                    </json:object>
                    <json:number name="progress">76.8</json:number>
                    <json:boolean name="active">true</json:boolean>
                    <json:string name="_type">item</json:string>
                    <json:object name="_links">
                        <json:object name="read">
                        <json:string name="href">http://test.com/items/id1</json:string>
                        <json:string name="method">GET</json:string>
                        </json:object>
                        <json:object name="update">
                        <json:string name="href">http://test.com/items/id1</json:string>
                        <json:string name="method">PUT</json:string>
                        </json:object>
                        <json:object name="delete">
                        <json:string name="href">http://test.com/items/id1</json:string>
                        <json:string name="method">DELETE</json:string>
                        </json:object>
                    </json:object>
                    </json:object>
                    <json:object>
                    <json:string name="id">id2</json:string>
                    <json:string name="name">B fancy Name</json:string>
                    <json:object name="treeValues">
                        <json:object name="1">
                        <json:number name="2">3</json:number>
                        <json:number name="3">4</json:number>
                        </json:object>
                    </json:object>
                    <json:number name="progress">24.7</json:number>
                    <json:boolean name="active">true</json:boolean>
                    <json:string name="_type">item</json:string>
                    <json:object name="_links">
                    <json:object name="read">
                        <json:string name="href">http://test.com/items/id2</json:string>
                        <json:string name="method">GET</json:string>
                    </json:object>
                    <json:object name="update">
                        <json:string name="href">http://test.com/items/id2</json:string>
                        <json:string name="method">PUT</json:string>
                    </json:object>
                    <json:object name="delete">
                        <json:string name="href">http://test.com/items/id2</json:string>
                        <json:string name="method">DELETE</json:string>
                    </json:object>
                    </json:object>
                    </json:object>
                    <json:object>
                    <json:string name="id">id3</json:string>
                    <json:string name="name">C fancy Name</json:string>
                    <json:object name="treeValues">
                        <json:object name="1">
                        <json:number name="2">3</json:number>
                        <json:number name="3">4</json:number>
                        <json:number name="6">7</json:number>
                        </json:object>
                    </json:object>
                    <json:number name="progress">100</json:number>
                    <json:boolean name="active">false</json:boolean>
                    <json:string name="_type">item</json:string>
                    <json:object name="_links">
                    <json:object name="read">
                        <json:string name="href">http://test.com/items/id3</json:string>
                        <json:string name="method">GET</json:string>
                    </json:object>
                    <json:object name="update">
                        <json:string name="href">http://test.com/items/id3</json:string>
                        <json:string name="method">PUT</json:string>
                    </json:object>
                    <json:object name="delete">
                        <json:string name="href">http://test.com/items/id3</json:string>
                        <json:string name="method">DELETE</json:string>
                    </json:object>
                    </json:object>
                    </json:object>
                </json:array>
                </json:object>
                <json:object name="_links">
                <json:object name="self">
                    <json:string name="href">http://test.com/items/?page=1&amp;perPage=10&amp;sort=name&amp;order=asc</json:string>
                    <json:string name="method">GET</json:string>
                </json:object>
                <json:object name="create">
                    <json:string name="href">http://test.com/items/</json:string>
                    <json:string name="method">POST</json:string>
                </json:object>
                </json:object>
                <json:string name="_type">search</json:string>
            </json:object>
            EOD;

        $decoder = new XmlTypeDecoder();

        self::assertEquals($expectedData, $decoder->decode($xml));
    }
}
