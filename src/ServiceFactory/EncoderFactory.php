<?php

declare(strict_types=1);

namespace Chubbyphp\DecodeEncode\ServiceFactory;

use Chubbyphp\DecodeEncode\Encoder\Encoder;
use Chubbyphp\DecodeEncode\Encoder\EncoderInterface;
use Chubbyphp\DecodeEncode\Encoder\TypeEncoderInterface;
use Chubbyphp\Laminas\Config\Factory\AbstractFactory;
use Psr\Container\ContainerInterface;

final class EncoderFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container): EncoderInterface
    {
        return new Encoder(
            $container->get(TypeEncoderInterface::class.'[]'.$this->name)
        );
    }
}
