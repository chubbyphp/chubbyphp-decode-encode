# Decoder

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\Decoder;
use Chubbyphp\DecodeEncode\Decoder\JsonTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\JsonxTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\UrlEncodedTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\XmlTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\YamlTypeDecoder;

$decoder = new Decoder([
    new JsonTypeDecoder(),
    new JsonxTypeDecoder(),
    new UrlEncodedTypeDecoder(),
    new XmlTypeDecoder(),
    new YamlTypeDecoder()
]);

print_r($decoder->getContentTypes());
//[
//    'application/json',
//    'application/jsonx+xml',
//    'application/x-www-form-urlencoded',
//    'application/xml',
//    'application/x-yaml'
//]

print_r($decoder->decode(
    '{"name": "php"}',
    'application/json'
));
// ['name' => 'php']
```
