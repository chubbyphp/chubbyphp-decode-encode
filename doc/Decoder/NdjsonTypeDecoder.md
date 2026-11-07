# NdjsonTypeDecoder

Decodes [JSON Lines][1] / [NDJSON][2]: one json value per line, separated by `\n` (`\r\n` is accepted as well).
The result is a list with one entry per line.

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\NdjsonTypeDecoder;

$decoderType = new NdjsonTypeDecoder();

echo $decoderType->getContentType();
// 'application/jsonl'

print_r($decoderType->decode("{\"name\": \"php\"}\n{\"name\": \"typescript\"}\n"));
// [['name' => 'php'], ['name' => 'typescript']]
```

Empty lines (only containing json whitespace: space, tab, carriage return) are invalid by default, and the error message
contains the line number:

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\NdjsonTypeDecoder;

$decoderType = new NdjsonTypeDecoder();

$decoderType->decode("{\"name\": \"php\"}\n\n{\"name\": \"typescript\"}\n");
// RuntimeException: Data is not parsable with content-type: "application/jsonl", error: "Line 2: Empty line"
```

## with custom content type and ignore empty lines

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\NdjsonTypeDecoder;

$decoderType = new NdjsonTypeDecoder('application/x-ndjson', true);

echo $decoderType->getContentType();
// 'application/x-ndjson'

print_r($decoderType->decode("{\"name\": \"php\"}\n\n{\"name\": \"typescript\"}\n"));
// [['name' => 'php'], ['name' => 'typescript']]
```

[1]: https://jsonlines.org
[2]: https://github.com/ndjson/ndjson-spec
