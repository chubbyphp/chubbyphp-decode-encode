# YamlTypeEncoder

```php
<?php

use Chubbyphp\DecodeEncode\Encoder\YamlTypeEncoder;

$encoderType = new YamlTypeEncoder();

echo $encoderType->getContentType();
// 'application/x-yaml'

echo $encoderType->encode(['name' => 'php']);
// 'name: php'
```
