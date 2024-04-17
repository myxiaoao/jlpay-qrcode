<?php

use Cooper\JlPayQrcode\Api;
use Cooper\JlPayQrcode\RSA;

//商户 RSA 私钥
const MER_PRI_KEY = 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCKyPtFB5Mqw1NaYzek99q3KZ/QH/XHx0rQ1DrG6TqqYqef/dtIVaJ6vokkWh5kCmbSiGKYJJSk5WMsv4S38ZBWXETN6o0DqZtiJ2KR79cy25GbQmw5nAC3C1h62G2lLFw0Rrwb1hQ+aoDqBMi+9nc71RhSESxwek3moySBFV44YBbBuHAKV/u1FGmB5loCDdbTJNKKIcyyTphfkgMfbMGZyhGQ70NidvksJImSGCyIlfswuRsyKKg9eJ+dJlzMyYsls5bJXMBq2R2WpueSImSMAW0YgiZdvjoYbY+ho4jNjX5zHJyT6M9m6llOJfHFL1tQoDEOXKiUUdtabTdlPnbRAgMBAAECggEAF5nwKSANpeMLpL5ksxg3SJi6hcE5odzBW1wMFtGI2XrneKzKArYVaHxIhDcTHf4q2Di7U5Y89QHRaMW1AzcATb9pL/9oNaw9MWbzO1AnL43paBbWosFl2bsDM/jkRIeTsowo5y7zyF2CSMnBfcAaLMGjXilvfj0+TC+IQK9qk3l7KYGLnx7+6OUbCMb455EC3WS0Md4ss3yyX+GfHkyLSPOd3gaL094JsgOBw7g3+OHgjYf8rcKIvnta+jZoXsUARMw2gKExUgesA7FiDyVgZ1QYXY/Qd2yRvlKPVWjmz7RSj/8EUTWk53zLJiQTa1Yxb05baqmfUQPLyO8QgjzUxQKBgQDVhUbb2ePG7J1fTzB+I6CuXo+cwfy0RTCQP4Kx6wdHM4Hb/jWbAhW55z2INaOMbHiu0fxN4qAerdIWoNgjqOV8iesaZxvWGfMtZjzp1iGujZmOE0yCrYFsBMZQy9U/7XN+PFY//EOd5H+rGa8ZNCkpk9y7iSTfYL6ItV+He1Z1vwKBgQCmZWIAl5MlX2xQgwNd46pc7rNyr1oS8baxckTzuAWcc9wMSApawGW2nqoMVejWYq57OCiYWQm7UEwRpMf/F1FY3/4o5EU8G1r99nOk66HmviW5ipGiJNrnOzk6Mimbqwm1giYdvcybcZwS/6DSeFFD6weeBBR7S7bcp4PD9aLXbwKBgHIzMk7sHvOKIjGTvS/6Bjq8wLrq1inkx7CfB1v5hI8EcXQkZq9dUhl4IGT1q1+ztGhsTzGpAFLoTPFlXbTU5MjTSzd35l+AyZuCjxnSOXmOqo5erBFIk2wesaMNIiVq7taZltfqKJAOYmo09n3YdBuUxf5Xv6zppX6g41MnGHspAoGAJ4TaosNdGjowkmqbSRhCJPI4QlutK+SmfDxkbfHdu0u1DmGpu+YIAjhqsKVSuGAVioRK9+vlqMwoVORq74XNNytzxKh6XQ0uLjTzQE8KU7ADa66iaf0Q1Gw3aj/xq9wSYT546QVj6+Muq0B1JKeYvWW7mGblqmbQFlXesJLNSxcCgYEAzVK84uFVl/pkrLKz2fJPAokHC+aNWDRWGjD4DaCn/qnRxdCoFaqvic3o8ZVeagBRmK4zF2L1X23YpAXZ2G+Zo+1WAiZGhp3enox7EK0JvbgB9YGHz9n8ZmeAa7cV7Pa4zIrVNCz/OX0OvBeArCUs/Fu4f55wzMlxTzglJjzYccw=';

//嘉联RSA公钥
const JL_PUB_KEY = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiIrhE4lgqU9w9e8HerCG5gYwHWTMUOt/dRpDpLCWzZXvxO/fgWodIFQZ895MJI65UDPxxKcR2ffEYH7bbBnAcyhNk83HdaJPthgtpxj6atIvzLdygLJR1qlBgVTZwQMBOyKoCweWDtYyPcuuc3AemnLlFXourSK2f1usPpxtJOX0eBhDGuUtua/t1lhm3UcgCx6UwKwjiwS1frblv25ms/uXjsjnC1v/abr971YeEf+n0rqlLQr5V/wYVheSe/8jPadCXOZGPs3iHBJR2bnkWr+5B64xstP151z/ysMeloNDua25ZoaLhnRa/+3d6K5V+W918WVdAdpvvj2HNC+W2wIDAQAB';

//机构号
const ORG_CODE = '50720711';

//商户号
const MCH_ID = '849584358120018';

function rsa(): RSA
{
    return new RSA(JL_PUB_KEY, MER_PRI_KEY);
}

function makeApi(): Api
{
    return Api::make([
        'public_key' => JL_PUB_KEY,
        'private_key' => MER_PRI_KEY,
        'org_code' => ORG_CODE,
        'mch_id' => MCH_ID,
        'uat' => true,
    ]);
}

function generateOrderNumber(): string
{
    return str_pad(time(), 10, '0', STR_PAD_LEFT);
}
