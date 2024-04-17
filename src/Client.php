<?php

declare(strict_types=1);

namespace Cooper\JlPayQrcode;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use JsonException;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use RuntimeException;

class Client
{
    public const BASE_URL = 'https://qrcode.jlpay.com/';

    public const UAT_BASE_URL = 'https://qrcode-uat.jlpay.com/';

    public const OPENAPI_BASE_URL = 'https://openapi.jlpay.com/';

    public const OPENAPI_UAT_BASE_URL = 'https://openapi-uat.jlpay.com/';

    private string $baseUrl;

    private string $baseOpenapiUrl;

    private string $orgCode;

    private string $mchId;

    private GuzzleClient $client;

    private RSA $signature;

    public function __construct(
        string $publicKey,
        string $privateKey,
        string $orgCode,
        string $mchId,
        bool $uat = false,
        array $options = []
    ) {
        date_default_timezone_set('Asia/Shanghai');

        $this->signature = new RSA($publicKey, $privateKey);
        $this->orgCode = $orgCode;
        $this->mchId = $mchId;
        $this->baseUrl = $uat ? self::UAT_BASE_URL : self::BASE_URL;
        $this->baseOpenapiUrl = $uat ? self::OPENAPI_UAT_BASE_URL : self::OPENAPI_BASE_URL;
        $this->client = $this->getGuzzleClient($options);
    }

    private function getGuzzleClient($options): GuzzleClient
    {
        if (isset($options['logger']['path']) && is_array($options['logger'])) {
            $logger = new Logger($options['logger']['name'] ?? 'jlpay-allocate');
            $logger->pushHandler(
                new RotatingFileHandler($options['logger']['path'], $options['logger']['day'] ?? 30)
            );

            $stack = HandlerStack::create();
            $stack->push(
                Middleware::log(
                    $logger,
                    new MessageFormatter('{method} - {target} - HTTP/{version} - {code} - {req_body} - {res_body}')
                )
            );

            return new GuzzleClient(['handler' => $stack]);
        }

        return new GuzzleClient();
    }

    public function filterNullValues(array $data): array
    {
        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendOpenApiRequest(string $endpoint, array $data): array
    {
        $url = $this->baseOpenapiUrl.ltrim($endpoint, '/');
        $data['agentId'] = $this->orgCode;
        $data['signData'] = $this->signData($data, $data['signData']);

        $response = $this->client->request('POST', $url, ['form_params' => $data]);

        return json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendRequest(string $endpoint, array $data): array
    {
        $url = $this->baseUrl.ltrim($endpoint, '/');

        $data['org_code'] = $this->orgCode;
        $data['mch_id'] = $this->mchId;
        $data['nonce_str'] = bin2hex(random_bytes(16));
        $data['sign'] = $this->sign($data);

        $response = $this->client->request('POST', $url, [
            'json' => $data,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $sign = $body['sign'] ?? '';
        if ($sign !== '') {
            $toSortedQueryString = $this->toSortedQueryString($body);
            $verify = $this->signature->verify($toSortedQueryString, $sign);
            if (! $verify) {
                throw new RuntimeException('签名检校失败');
            }
        }

        return $body;
    }

    /**
     * @throws JsonException
     */
    private function sign(array $data): string
    {
        return $this->signature->sign($this->toSortedQueryString($data));
    }

    private function signData(array $data, string $signData): string
    {
        unset($data['signData']);

        return $this->signature->signData($data, $signData);
    }

    /**
     * @throws JsonException
     */
    private function toSortedQueryString(array $properties): string
    {
        unset($properties['sign']);
        ksort($properties);

        return json_encode($properties, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}
