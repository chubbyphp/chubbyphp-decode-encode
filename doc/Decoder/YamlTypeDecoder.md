# YamlTypeDecoder

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\YamlTypeDecoder;

$decoderType = new YamlTypeDecoder();

echo $decoderType->getContentType();
// 'application/x-yaml'

print_r($decoderType->decode('name: php'));
// ['name' => 'php']
```
