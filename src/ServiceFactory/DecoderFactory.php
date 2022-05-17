<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\ServiceFactory;

use Chubbyphp\DecodeEncode\Decoder\Decoder;
use Chubbyphp\DecodeEncode\Decoder\DecoderInterface;
use Chubbyphp\DecodeEncode\Decoder\TypeDecoderInterface;
use Chubbyphp\Laminas\Config\Factory\AbstractFactory;
use Psr\Container\ContainerInterface;

final class DecoderFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container): DecoderInterface
    {
        return new Decoder(
            $container->get(TypeDecoderInterface::class.'[]'.$this->name)
        );
    }
}
