# JiaLian Payment PHP SDK.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cooper/jlpay-qrcode.svg?style=flat-square)](https://packagist.org/packages/cooper/jlpay-qrcode)
[![Tests](https://img.shields.io/github/actions/workflow/status/myxiaoao/jlpay-qrcode/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/myxiaoao/jlpay-qrcode/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/cooper/jlpay-qrcode.svg?style=flat-square)](https://packagist.org/packages/cooper/jlpay-qrcode)

## Installation

You can install the package via composer:

```bash
composer require cooper/jlpay-qrcode
```

## Usage

```php
$api = new Cooper\JlPayQrcode\Api((JL_PUB_KEY, MER_PRI_KEY, ORG_CODE, MER_ID));
$res = $api->sendChnQueryRequest(transactionId: '451113671593190188646497'); // 查询订单
var_dump($res);
```

> Check the API methods corresponding to the API class.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Cooper](https://github.com/cooper)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
