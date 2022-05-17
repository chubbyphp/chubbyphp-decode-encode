# DecoderFactory

## without name (default)

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\DecodeEncode\ServiceFactory\DecoderFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

// $container->get(TypeDecoderInterface::class.'[]')

$factory = new DecoderFactory();

$decoder = $factory($container);
```

## with name (default)

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\DecodeEncode\ServiceFactory\DecoderFactory;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = ...;

// $container->get(TypeDecoderInterface::class.'[]default')

$factory = [DecoderFactory::class, 'default'];

$decoder = $factory($container);
```
