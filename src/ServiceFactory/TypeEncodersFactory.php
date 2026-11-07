<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\ServiceFactory;

use Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\JsonxTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\NdjsonTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\TypeEncoderInterface;
use Chubbyphp\DecodeEncode\Encoder\UrlEncodedTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\YamlTypeEncoder;
use Psr\Container\ContainerInterface;

final class TypeEncodersFactory
{
    /**
     * @return list<TypeEncoderInterface>
     */
    public function __invoke(ContainerInterface $container): array
    {
        /** @var array{debug: bool} $config */
        $config = $container->get('config');

        $debug = $config['debug'];

        return [
            new JsonTypeEncoder($debug),
            new JsonxTypeEncoder($debug),
            new NdjsonTypeEncoder(),
            new NdjsonTypeEncoder('application/x-jsonl'),
            new NdjsonTypeEncoder('text/jsonl'),
            new NdjsonTypeEncoder('application/ndjson'),
            new NdjsonTypeEncoder('application/x-ndjson'),
            new UrlEncodedTypeEncoder(),
            new YamlTypeEncoder(),
            new YamlTypeEncoder('application/yaml'),
        ];
    }
}
