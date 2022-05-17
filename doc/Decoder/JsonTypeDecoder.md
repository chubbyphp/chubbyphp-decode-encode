# JsonTypeDecoder

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\JsonTypeDecoder;

$decoderType = new JsonTypeDecoder();

echo $decoderType->getContentType();
// 'application/json'

print_r($decoderType->decode('{"name": "php"}'));
// ['name' => 'php']
```
