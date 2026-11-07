# NdjsonTypeEncoder

Encodes a list into [JSON Lines][1] / [NDJSON][2]: one json value per line, each line terminated by `\n`.
Passing anything else than a list throws a `RuntimeException`.

```php
<?php

use Chubbyphp\DecodeEncode\Encoder\NdjsonTypeEncoder;

$encoderType = new NdjsonTypeEncoder();

echo $encoderType->getContentType();
// 'application/jsonl'

echo $encoderType->encode([['name' => 'php'], ['name' => 'typescript']]);
// "{\"name\":\"php\"}\n{\"name\":\"typescript\"}\n"

$encoderType->encode(['name' => 'php']);
// RuntimeException: Data is not encodable with content-type: "application/jsonl", error: "Not a list"
```

## with custom content type

```php
<?php

use Chubbyphp\DecodeEncode\Encoder\NdjsonTypeEncoder;

$encoderType = new NdjsonTypeEncoder('application/x-ndjson');

echo $encoderType->getContentType();
// 'application/x-ndjson'
```

[1]: https://jsonlines.org
[2]: https://github.com/ndjson/ndjson-spec
