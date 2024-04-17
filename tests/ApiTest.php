<?php

use Cooper\JlPayQrcode\RSA;

it('test sign', function () {
    $str =
        '{"attach":"test","body":"测试","device_info":"80005611","latitude":"22.144889","longitude":"113.571558","mch_create_ip":"172.20.6.21","mch_id":"849440350000000","nonce_str":"123456789","notify_url":"http://172.20.6.21:5000notify/","op_shop_id":"1001","op_user_id":"1001","org_code":"50360000","out_trade_no":"20191104888001","pay_type":"alipay","remark":"测试","service":"pay.qrcode.qrcodepay","sign_type":"RSA256","term_no":"800056","total_fee":"1"}';
    $RSA = new RSA(
        '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'
    );
    $sign = $RSA->sign($str);

    expect($sign)->toBe(
        'ZaTPTwYxqFfMQBsBDkr3OvuWJNzHmZRpC2rqYDdzg10OVWDkQoJA4FKgelGtbUaN27Mw/cLmDZr8buJos54+djnsNEVLOjJTrmlT39sWw46qLNzpzeHHHyNukaddHe7cUh3UqhrQxgMUO5c7BpEhpuxlkiBa5hf4PiWjRAqPBZoupBQ3GKhAk3qs1v7o2lvQUOa6VPEtZe//ABwRdQUoFqy6J6LOapZh4fr5I2Z4PJdghbG8oGtBbOr7O5An2ZM7BQU6FjZC57qOV265ry2CrX5u6Zf34j+Xt6TeUZj26QLY09bih/e9oaeB5BPhwcZTQcjtKIoedyraA1CMJfCqIA=='
    );
});

it('test open api sign', function () {
    $json_decode = json_decode(
        '{"agentId":"50720711","msgTranCode":"MER009","source":"9","merchNo":"849584358120018","areaCode":"440305","detAddress":"广东省深圳南山区科技生态园22栋","signMethod":"02"}',
        true,
        512,
        JSON_THROW_ON_ERROR
    );
    $signData = rsa()->signData($json_decode, 'agentId,source,merchNo,signMethod');
    expect($signData)->toBe(
        'YPiOPqmUXNti6V0/BPeDDWbhUshWu8ZL9kB7MDPxavGpg2mi49CRzUYzse+rvXLj9rPrYBJEFMZYC3s0MHiYnBbgr2n94SrIIuUuDg8EPqMoWrK+EFPUGYyr13BlNzj4Hyi4fv+rQux4S8w4uFSPlpNwoty4xzVsVmyqQYcdnGhIvGjzdZ8xUYQyV9x0P17rTCTJZ0ekFWHY+w+M1CUIy2CozzI0u/L5XP3RP9mvkv6Y9zWeC+0DV7IG+EHT23xwX5Qs7tr/ccXSP22p3eJLznQfzaimkvSCNLjjgg807g771JOdKDjjGhwy7x3I3M1nyZ/BP19j3MFTsD9qnPS22A=='
    );
});

it('test verify', function () {
    $verify = rsa()->verify(
        '{"mch_id":"849584358120018","org_code":"50720711","ret_code":"BIZ_ERROR","ret_msg":"终端IP、经纬度信息二者必填其一[BIZ_ERROR]","sign_type":"RSA"}',
        'IZWw+5n0bjX+ON2DcJOS0vZuWhYgsUSjV6H/9j0CrG1K4DP6i6faHce6fwEJG4upkjLitB0LW5Y8b6lBX40XRTjmYzX9Z97xysIhbjyNKA8kHrAzS8sf9XQXuSZTBeNBBl0qChjJZROVlNpL4f4UtR8wADARlNyf71oNu6UIHYWP//crTwYyU8RK2uloSghYXKeENJZe2TzaHpUK1T1iTTGmFhbtwJN59Fe8f7q1bqdbIyc/F7zn3X8KMfHvAqI02+m2SUzuHJKk4FbejPhyzPp6ZZJ4oZ1vH4OZj6dLbjVuaWz836gA0FMMdefRvgcvSM3VOA5Tm/4gRjOSD8C+Dw=='
    );
    expect($verify)->toBeTrue();
});

it('test chnquery', function () {
    $sendChnQueryRequest = makeApi()->sendChnQueryRequest(transactionId: '451113671593190188646497');
    expect($sendChnQueryRequest['transaction_id'])->toBe('451113671593190188646497')
        ->and($sendChnQueryRequest['out_trade_no'])->toBe('1713315096');
});
