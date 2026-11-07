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

## with custom content type

```php
<?php

use Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder;

$encoderType = new JsonTypeEncoder(false, 'application/problem+json');

echo $encoderType->getContentType();
// 'application/problem+json'

echo $encoderType->encode(['type' => 'about:blank', 'status' => 400]);
// '{"type":"about:blank","status":400}'
```
