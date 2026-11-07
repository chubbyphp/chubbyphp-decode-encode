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

## with custom content type

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\JsonTypeDecoder;

$decoderType = new JsonTypeDecoder('application/problem+json');

echo $decoderType->getContentType();
// 'application/problem+json'

print_r($decoderType->decode('{"type": "about:blank", "status": 400}'));
// ['type' => 'about:blank', 'status' => 400]
```
