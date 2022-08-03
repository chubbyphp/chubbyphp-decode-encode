# chubbyphp-decode-encode

[![CI](https://github.com/chubbyphp/chubbyphp-decode-encode/workflows/CI/badge.svg?branch=master)](https://github.com/chubbyphp/chubbyphp-decode-encode/actions?query=workflow%3ACI)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-decode-encode/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-decode-encode?branch=master)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/chubbyphp/chubbyphp-decode-encode/master)](https://dashboard.stryker-mutator.io/reports/github.com/chubbyphp/chubbyphp-decode-encode/master)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-decode-encode/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-decode-encode)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-decode-encode/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-decode-encode)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-decode-encode/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-decode-encode)

[![bugs](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=bugs)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![code_smells](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=code_smells)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![coverage](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=coverage)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![duplicated_lines_density](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=duplicated_lines_density)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![ncloc](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=ncloc)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![sqale_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![alert_status](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=alert_status)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![reliability_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![security_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=security_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![sqale_index](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=sqale_index)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)
[![vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-decode-encode&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-decode-encode)

## Description

A simple decode/encode solution for json / jsonx / url-encoded / xml / yaml.

## Requirements

 * php: ^8.0
 * symfony/yaml: ^4.4.38|^5.4.5|^6.0

## Suggest

 * chubbyphp/chubbyphp-container: ^2.1
 * psr/container: ^1.1.2|^2.0.2

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-decode-encode][1].

```sh
composer require chubbyphp/chubbyphp-decode-encode "^1.0"
```

## Usage

### Decoder

```php
<?php

use Chubbyphp\DecodeEncode\Decoder\Decoder;
use Chubbyphp\DecodeEncode\Decoder\JsonTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\JsonxTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\UrlEncodedTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\XmlTypeDecoder;
use Chubbyphp\DecodeEncode\Decoder\YamlTypeDecoder;

$decoder = new Decoder([
    new JsonTypeDecoder(),
    new JsonxTypeDecoder(),
    new UrlEncodedTypeDecoder(),
    new XmlTypeDecoder(),
    new YamlTypeDecoder()
]);

print_r($decoder->getContentTypes());
//[
//    'application/json',
//    'application/jsonx+xml',
//    'application/x-www-form-urlencoded',
//    'application/xml',
//    'application/x-yaml'
//]

print_r($decoder->decode(
    '{"name": "php"}',
    'application/json'
));
// ['name' => 'php']
```

#### Type Decoder

 * [JsonTypeDecoder][3]
 * [JsonxTypeDecoder][4]
 * [UrlEncodedTypeDecoder][5]
 * [XmlTypeDecoder][6]
 * [YamlTypeDecoder][7]

### Encoder

# Encoder

```php
<?php

use Chubbyphp\DecodeEncode\Encoder\Encoder;
use Chubbyphp\DecodeEncode\Encoder\JsonTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\JsonxTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\UrlEncodedTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\XmlTypeEncoder;
use Chubbyphp\DecodeEncode\Encoder\YamlTypeEncoder;

$encoder = new Encoder([
    new JsonTypeEncoder(),
    new JsonxTypeEncoder(),
    new UrlEncodedTypeEncoder(),
    new XmlTypeEncoder(),
    new YamlTypeEncoder()
]);

print_r($encoder->getContentTypes());
//[
//    'application/json',
//    'application/jsonx+xml',
//    'application/x-www-form-urlencoded',
//    'application/xml',
//    'application/x-yaml'
//]

echo $encoder->encode(
    ['name' => 'php'],
    'application/json'
);
// '{"name": "php"}'
```

#### Type Encoder

 * [JsonTypeEncoder][11]
 * [JsonxTypeEncoder][12]
 * [UrlEncodedTypeEncoder][13]
 * [XmlTypeEncoder][14]
 * [YamlTypeEncoder][15]

### ServiceFactory

#### chubbyphp-laminas-config-factory

 * [DecoderFactory][20]
 * [EncoderFactory][21]

## Copyright

Dominik Zogg 2022


[1]: https://packagist.org/packages/chubbyphp/chubbyphp-decode-encode

[3]: doc/Decoder/JsonTypeDecoder.md
[4]: doc/Decoder/JsonxTypeDecoder.md
[5]: doc/Decoder/UrlEncodedTypeDecoder.md
[6]: doc/Decoder/XmlTypeDecoder.md
[7]: doc/Decoder/YamlTypeDecoder.md

[11]: doc/Encoder/JsonTypeEncoder.md
[12]: doc/Encoder/JsonxTypeEncoder.md
[13]: doc/Encoder/UrlEncodedTypeEncoder.md
[14]: doc/Encoder/XmlTypeEncoder.md
[15]: doc/Encoder/YamlTypeEncoder.md

[20]: doc/ServiceFactory/DecoderFactory.md
[21]: doc/ServiceFactory/EncoderFactory.md
