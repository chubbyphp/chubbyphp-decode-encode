# Encoder

```php
<?php

use Chubbyphp\DecodeEncode\Encoder\Encoder;
use Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\JsonxTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\UrlEncodedTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\XmlTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\YamlTypeEncoder;

$encoder = new Encoder([
    new JsonTypeEncoder(),
    new JsonxTypeEncoder(),
    new UrlEncodedTypeEncoder(),
    new XmlTypeEncoder(),
    new YamlTypeEncoder()
]);

print_r($encoder->getContentTypes());
//[
//    'application/json',
//    'application/jsonx+xml',
//    'application/x-www-form-urlencoded',
//    'application/xml',
//    'application/x-yaml'
//]

echo $encoder->encode(
    ['name' => 'php'],
    'application/json'
);
// '{"name": "php"}'
```
