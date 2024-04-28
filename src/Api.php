<?php

declare(strict_types=1);

namespace Cooper\JlPayQrcode;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class Api
{
    private Client $client;

    public function __construct(
        string $publicKey,
        string $privateKey,
        string $orgCode,
        string $mchId,
        bool $uat = false,
        array $options = []
    ) {
        $this->client = new Client($publicKey, $privateKey, $orgCode, $mchId, $uat, $options);
    }

    public static function make(array $config): self
    {
        return new self(
            $config['public_key'],
            $config['private_key'],
            $config['org_code'],
            $config['mch_id'],
            $config['uat'] ?? false,
            $config['options'] ?? []
        );
    }

    /**
     * 码付加机接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendMerchClientAddQrDeviceRequest(
        string $merchNo,
        string $msgTranCode = 'MER009',
        string $source = '9',
        string $signMethod = '02',
        string $signData = 'agentId,source,merchNo,signMethod',
        ?string $areaCode = null,
        ?string $detAddress = null,
        ?string $deviceType = null,
        ?string $remark = null
    ): array {
        $data = $this->client->filterNullValues([
            'msgTranCode' => $msgTranCode,
            'source' => $source,
            'merchNo' => $merchNo,
            'areaCode' => $areaCode,
            'detAddress' => $detAddress,
            'deviceType' => $deviceType,
            'remark' => $remark,
            'signMethod' => $signMethod,
            'signData' => $signData,
        ]);

        return $this->client->sendOpenApiRequest('access/merch/clientAddQrDevice', $data);
    }

    /**
     * 订单查询接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendChnQueryRequest(
        ?string $transactionId = null,
        ?string $outTradeNo = null,
        ?string $charset = 'UTF-8',
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'transaction_id' => $transactionId,
            'out_trade_no' => $outTradeNo,
            'charset' => $charset,
            'sign_type' => $signType,
        ]);

        return $this->client->sendRequest('api/pay/chnquery', $data);
    }

    /**
     * 订单退款接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendRefundRequest(
        string $outTradeNo,
        int $totalFee,
        ?string $oriTransactionId = null,
        ?string $oriOutTradeNo = null,
        ?string $remark = null,
        ?string $mchCreateIp = null,
        ?string $longitude = null,
        ?string $latitude = null,
        ?string $charset = 'UTF-8',
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'out_trade_no' => $outTradeNo,
            'total_fee' => $totalFee,
            'ori_out_trade_no' => $oriOutTradeNo,
            'ori_transaction_id' => $oriTransactionId,
            'remark' => $remark,
            'mch_create_ip' => $mchCreateIp,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'charset' => $charset,
            'sign_type' => $signType,
        ]);

        return $this->client->sendRequest('api/pay/refund', $data);
    }

    /**
     * 订单关闭接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendCancelRequest(
        string $outTradeNo,
        ?string $oriTransactionId = null,
        ?string $oriOutTradeNo = null,
        ?string $remark = null,
        ?string $mchCreateIp = null,
        ?string $longitude = null,
        ?string $latitude = null,
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'out_trade_no' => $outTradeNo,
            'ori_out_trade_no' => $oriOutTradeNo,
            'ori_transaction_id' => $oriTransactionId,
            'remark' => $remark,
            'mch_create_ip' => $mchCreateIp,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'sign_type' => $signType,
        ]);

        return $this->client->sendRequest('api/pay/cancel', $data);
    }

    /**
     * 付款码支付下单接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendMicroPayRequest(
        string $outTradeNo,
        string $body,
        string $attach,
        int $totalFee,
        string $authCode,
        ?string $paymentValidTime = '20',
        ?string $limitPay = null,
        ?string $isHirePurchase = null,
        ?string $hirePurchaseNum = null,
        ?string $hirePurchaseSellerPercent = null,
        ?string $remark = null,
        ?string $opUserId = null,
        ?string $deviceInfo = null,
        ?string $mchCreateIp = null,
        ?string $longitude = null,
        ?string $latitude = null,
        ?string $subAppid = null,
        ?string $goodsTag = null,
        ?string $goodsData = null,
        ?string $terminalInfo = null,
        ?string $payType = 'wxpay',
        ?string $charset = 'UTF-8',
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'out_trade_no' => $outTradeNo,
            'body' => $body,
            'attach' => $attach,
            'total_fee' => $totalFee,
            'auth_code' => $authCode,
            'payment_valid_time' => $paymentValidTime,
            'limit_pay' => $limitPay,
            'is_hire_purchase' => $isHirePurchase,
            'hire_purchase_num' => $hirePurchaseNum,
            'hire_purchase_seller_percent' => $hirePurchaseSellerPercent,
            'remark' => $remark,
            'op_user_id' => $opUserId,
            'device_info' => $deviceInfo,
            'mch_create_ip' => $mchCreateIp,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'sub_appid' => $subAppid,
            'goods_tag' => $goodsTag,
            'goods_data' => $goodsData,
            'terminal_info' => $terminalInfo,
            'pay_type' => $payType,
            'charset' => $charset,
            'sign_type' => $signType,
        ]);

        return $this->client->sendRequest('api/pay/micropay', $data);
    }

    /**
     * 扫码支付下单接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendQrCodePayRequest(
        string $outTradeNo,
        string $body,
        string $attach,
        int $totalFee,
        ?string $notifyUrl = null,
        ?string $paymentValidTime = '20',
        ?string $limitPay = null,
        ?string $isHirePurchase = null,
        ?string $hirePurchaseNum = null,
        ?string $hirePurchaseSellerPercent = null,
        ?string $remark = null,
        ?string $opUserId = null,
        ?string $opShopId = null,
        ?string $deviceInfo = null,
        ?string $mchCreateIp = null,
        ?string $longitude = null,
        ?string $latitude = null,
        ?string $goodsTag = null,
        ?string $goodsData = null,
        ?string $terminalInfo = null,
        ?string $payType = 'wxpay',
        ?string $charset = 'UTF-8',
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'out_trade_no' => $outTradeNo,
            'body' => $body,
            'attach' => $attach,
            'total_fee' => $totalFee,
            'notify_url' => $notifyUrl,
            'payment_valid_time' => $paymentValidTime,
            'limit_pay' => $limitPay,
            'is_hire_purchase' => $isHirePurchase,
            'hire_purchase_num' => $hirePurchaseNum,
            'hire_purchase_seller_percent' => $hirePurchaseSellerPercent,
            'remark' => $remark,
            'op_user_id' => $opUserId,
            'op_shop_id' => $opShopId,
            'device_info' => $deviceInfo,
            'mch_create_ip' => $mchCreateIp,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'goods_tag' => $goodsTag,
            'goods_data' => $goodsData,
            'terminal_info' => $terminalInfo,
            'pay_type' => $payType,
            'charset' => $charset,
            'sign_type' => $signType,
        ]);

        return $this->client->sendRequest('api/pay/qrcodepay', $data);
    }

    /**
     * 微信公众号小程序下单接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendOfficialPayRequest(
        string $outTradeNo,
        string $body,
        string $attach,
        int $totalFee,
        string $openId,
        ?string $subAppid = null,
        ?string $notifyUrl = null,
        ?string $paymentValidTime = '20',
        ?string $limitPay = null,
        ?string $remark = null,
        ?string $opUserId = null,
        ?string $opShopId = null,
        ?string $deviceInfo = null,
        ?string $mchCreateIp = null,
        ?string $longitude = null,
        ?string $latitude = null,
        ?string $goodsTag = null,
        ?string $goodsData = null,
        ?string $terminalInfo = null,
        ?string $payType = 'wxpay',
        ?string $charset = 'UTF-8',
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'out_trade_no' => $outTradeNo,
            'body' => $body,
            'attach' => $attach,
            'total_fee' => $totalFee,
            'open_id' => $openId,
            'sub_appid' => $subAppid,
            'notify_url' => $notifyUrl,
            'payment_valid_time' => $paymentValidTime,
            'limit_pay' => $limitPay,
            'remark' => $remark,
            'op_user_id' => $opUserId,
            'op_shop_id' => $opShopId,
            'device_info' => $deviceInfo,
            'mch_create_ip' => $mchCreateIp,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'goods_tag' => $goodsTag,
            'goods_data' => $goodsData,
            'terminal_info' => $terminalInfo,
            'pay_type' => $payType,
            'charset' => $charset,
            'sign_type' => $signType,
        ]);

        return $this->client->sendRequest('api/pay/officialpay', $data);
    }

    /**
     * 绑定支付目录接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendAuthBindRequest(
        string $mchCreateIp,
        ?string $jsapiPath = null,
        ?string $subAppid = null,
        ?string $payType = 'wxpay',
        ?string $charset = 'UTF-8',
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'jsapi_path' => $jsapiPath,
            'sub_appid' => $subAppid,
            'pay_type' => $payType,
            'charset' => $charset,
            'sign_type' => $signType,
            'mch_create_ip' => $mchCreateIp,
        ]);

        return $this->client->sendRequest('api/pay/authbind', $data);
    }

    /**
     * 支付宝服务窗小程序下单接口
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendWapH5PayRequest(
        string $outTradeNo,
        string $body,
        string $attach,
        int $totalFee,
        ?string $buyerLogonId = null,
        ?string $buyerId = null,
        ?string $notifyUrl = null,
        ?string $paymentValidTime = '20',
        ?string $limitPay = null,
        ?string $isHirePurchase = null,
        ?string $hirePurchaseNum = null,
        ?string $hirePurchaseSellerPercent = null,
        ?string $remark = null,
        ?string $opUserId = null,
        ?string $opShopId = null,
        ?string $deviceInfo = null,
        ?string $mchCreateIp = null,
        ?string $longitude = null,
        ?string $latitude = null,
        ?string $goodsTag = null,
        ?string $goodsData = null,
        ?string $terminalInfo = null,
        ?string $payType = 'alipay',
        ?string $charset = 'UTF-8',
        ?string $signType = 'RSA',
    ): array {
        $data = $this->client->filterNullValues([
            'out_trade_no' => $outTradeNo,
            'body' => $body,
            'attach' => $attach,
            'total_fee' => $totalFee,
            'notify_url' => $notifyUrl,
            'buyer_logon_id' => $buyerLogonId,
            'buyer_id' => $buyerId,
            'payment_valid_time' => $paymentValidTime,
            'limit_pay' => $limitPay,
            'is_hire_purchase' => $isHirePurchase,
            'hire_purchase_num' => $hirePurchaseNum,
            'hire_purchase_seller_percent' => $hirePurchaseSellerPercent,
            'remark' => $remark,
            'op_user_id' => $opUserId,
            'op_shop_id' => $opShopId,
            'device_info' => $deviceInfo,
            'mch_create_ip' => $mchCreateIp,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'goods_tag' => $goodsTag,
            'goods_data' => $goodsData,
            'terminal_info' => $terminalInfo,
            'pay_type' => $payType,
            'charset' => $charset,
            'sign_type' => $signType,
        ]);

        return $this->client->sendRequest('api/pay/waph5pay', $data);
    }

    /**
     * @throws JsonException
     */
    public function notifySign(array $data, string $sign): bool
    {
        return $this->client->notifySign($data, $sign);
    }
}
