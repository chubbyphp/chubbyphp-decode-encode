# JsonTypeEncoder

```php
<?php

use Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder;

$encoderType = new JsonTypeEncoder();

echo $encoderType->getContentType();
// 'application/json'

echo $encoderType->encode(['name' => 'php']);
// '{"name": "php"}'
```
