<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\DecodeEncode\Unit\Encoder;

use Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder
 *
 * @internal
 */
final class JsonTypeEncoderTest extends TestCase
{
    public function testContentType(): void
    {
        $encoder = new JsonTypeEncoder();

        self::assertSame('application/json', $encoder->getContentType());
    }

    #[DataProviderExternal(TypeEncoderDataProvider::class, 'getExpectedData')]
    public function testFormat(array $data): void
    {
        $jsonencoder = new JsonTypeEncoder(true);

        $json = $jsonencoder->encode($data);

        $expectedJson = <<<'EOT'
            {
                "page": 1,
                "perPage": 10,
                "search": null,
                "sort": "name",
                "order": "asc",
                "_embedded": {
                    "mainItem": {
                        "id": "id1",
                        "name": "A fäncy Name\n",
                        "treeValues": {
                            "1": {
                                "2": 3
                            }
                        },
                        "progress": 76.8,
                        "active": true,
                        "_type": "item",
                        "_links": {
                            "read": {
                                "href": "http://test.com/items/id1",
                                "templated": false,
                                "rels": [],
                                "attributes": {
                                    "method": "GET"
                                }
                            },
                            "update": {
                                "href": "http://test.com/items/id1",
                                "templated": false,
                                "rels": [],
                                "attributes": {
                                    "method": "PUT"
                                }
                            },
                            "delete": {
                                "href": "http://test.com/items/id1",
                                "templated": false,
                                "rels": [],
                                "attributes": {
                                    "method": "DELETE"
                                }
                            }
                        }
                    },
                    "items": [
                        {
                            "id": "id1",
                            "name": "A fäncy Name\n",
                            "treeValues": {
                                "1": {
                                    "2": 3
                                }
                            },
                            "progress": 76.8,
                            "active": true,
                            "_type": "item",
                            "_links": {
                                "read": {
                                    "href": "http://test.com/items/id1",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "GET"
                                    }
                                },
                                "update": {
                                    "href": "http://test.com/items/id1",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "PUT"
                                    }
                                },
                                "delete": {
                                    "href": "http://test.com/items/id1",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "DELETE"
                                    }
                                }
                            }
                        },
                        {
                            "id": "id2",
                            "name": "B fancy Name",
                            "treeValues": {
                                "1": {
                                    "2": 3,
                                    "3": 4
                                }
                            },
                            "progress": 24.7,
                            "active": true,
                            "_type": "item",
                            "_links": {
                                "read": {
                                    "href": "http://test.com/items/id2",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "GET"
                                    }
                                },
                                "update": {
                                    "href": "http://test.com/items/id2",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "PUT"
                                    }
                                },
                                "delete": {
                                    "href": "http://test.com/items/id2",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "DELETE"
                                    }
                                }
                            }
                        },
                        {
                            "id": "id3",
                            "name": "C fancy Name",
                            "treeValues": {
                                "1": {
                                    "2": 3,
                                    "3": 4,
                                    "6": 7
                                }
                            },
                            "progress": 100.0,
                            "active": false,
                            "_type": "item",
                            "_links": {
                                "read": {
                                    "href": "http://test.com/items/id3",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "GET"
                                    }
                                },
                                "update": {
                                    "href": "http://test.com/items/id3",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "PUT"
                                    }
                                },
                                "delete": {
                                    "href": "http://test.com/items/id3",
                                    "templated": false,
                                    "rels": [],
                                    "attributes": {
                                        "method": "DELETE"
                                    }
                                }
                            }
                        }
                    ]
                },
                "_links": {
                    "self": {
                        "href": "http://test.com/items/?page=1&perPage=10&sort=name&order=asc",
                        "method": "GET"
                    },
                    "create": {
                        "href": "http://test.com/items/",
                        "method": "POST"
                    }
                },
                "_type": "search"
            }
            EOT;
        self::assertEquals($expectedJson, $json);
    }

    public function testFormatJsonIgnoreInvalidUtf8WithPrettyPrint(): void
    {
        $data = [
            'page' => 1,
            'perPage' => 10,
            'search' => null,
            'sort' => 'name',
            'order' => 'asc',
            'filter' => mb_convert_encoding('fieldÁ==value', 'ISO-8859-1', 'UTF-8'),
            '_links' => [
                'self' => [
                    'href' => 'http://test.com/items/?page=1&perPage=10&sort=name&order=asc',
                    'method' => 'GET',
                ],
                'create' => [
                    'href' => 'http://test.com/items/',
                    'method' => 'POST',
                ],
            ],
            '_type' => 'search',
        ];

        $jsonencoder = new JsonTypeEncoder();

        $json = $jsonencoder->encode($data);

        $expectedJson = '{"page":1,"perPage":10,"search":null,"sort":"name","order":"asc","filter":"field==value","_links":{"self":{"href":"http://test.com/items/?page=1&perPage=10&sort=name&order=asc","method":"GET"},"create":{"href":"http://test.com/items/","method":"POST"}},"_type":"search"}';

        self::assertEquals($expectedJson, $json);
    }
}
