<?php

declare(strict_types=1);

namespace Cooper\JlPayQrcode;

use RuntimeException;

class RSA
{
    private string $publicKey;

    private string $privateKey;

    public function __construct($publicKey, $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * RSA 签名
     */
    public function sign(string $data): string
    {
        $privateKey = chunk_split($this->privateKey, 64);
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n$privateKey-----END RSA PRIVATE KEY-----\n";
        $res = openssl_pkey_get_private($privateKey);

        if ($res) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);

            return base64_encode($sign);
        }

        throw new RuntimeException('RSA 签名错误');
    }

    /**
     * RSA 验签
     */
    public function verify(string $data, string $sign): bool
    {
        $publicKey = chunk_split($this->publicKey, 64);
        $publicKey = "-----BEGIN PUBLIC KEY-----\n$publicKey-----END PUBLIC KEY-----\n";
        $res = openssl_get_publickey($publicKey);

        if ($res) {
            return (bool) openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        }

        throw new RuntimeException('RSA 验签错误');
    }

    public function signData(array $data, string $signData): string
    {
        $expSignData = explode(',', $signData);
        $str = '';
        foreach ($expSignData as $datum) {
            $trim = trim($datum);
            if (isset($data[$trim])) {
                $str .= $data[$trim];
            }
        }

        return $this->sign($str);
    }
}
