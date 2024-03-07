<?php
namespace App\Utils;

class RsaUtil
{

    const publicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA7qIciNzY1mBr0HdSglAYP70hWw0TdtSFYwIvodQcyhkMBZET55OeP/ikYnCM6NCTz9ZI/NWmgwvzC3BhHvPXRLCKU6Xl8GSYSoGeKmpPBQivyBLSx2nX3wNIkBRBXek9ZueySql7dDGcjd/aPPIEXIK+96e0yii00lLxQSGgbG0AfSQro6Tt39qcHW9pzHiBdphaH6RtXjgtRr1dbvDEjIpjvzi3OpljiJlf1Kx/wOg03SNY6U3TYn0G88Y78KrWmF1MYPVUTRSG5DRQpW0U9E/bSHJISi8teR1tEc1+U6CPgEbi8nTQfIUh1rPUR1XaKy4Mdyu4Ao0XeX5fQMN70wIDAQAB";

    const privateKey = "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDuohyI3NjWYGvQd1KCUBg/vSFbDRN21IVjAi+h1BzKGQwFkRPnk54/+KRicIzo0JPP1kj81aaDC/MLcGEe89dEsIpTpeXwZJhKgZ4qak8FCK/IEtLHadffA0iQFEFd6T1m57JKqXt0MZyN39o88gRcgr73p7TKKLTSUvFBIaBsbQB9JCujpO3f2pwdb2nMeIF2mFofpG1eOC1GvV1u8MSMimO/OLc6mWOImV/UrH/A6DTdI1jpTdNifQbzxjvwqtaYXUxg9VRNFIbkNFClbRT0T9tIckhKLy15HW0RzX5ToI+ARuLydNB8hSHWs9RHVdorLgx3K7gCjRd5fl9Aw3vTAgMBAAECggEALsVtTFHk2hep6gEJFet25T8/g2YLs5Wx0xcBmPlG70F7frfRq+jd8nHcXkLrC1KeNfUs9wk1CqhT6aEMGBH41ki3w+9XIwfEZY4EHxIZDMaIFXHDCDyxh89P8JVXvn1RgJLW+hU/0iVLJu+CCcHxouQpY8bmA115G2QQTxC1LarKsqrIcud52pYo9rVmtVMDegYelukYQIahxgM3ODMRVwTS+7Zo9/x569Qx1PqLi1Tp0CNy2DdG+3F1/he4o6ohkYea4pJKEmQQZaPI5ya8ghrM3MZpD0j9JN6WmLTuoSZB4MWA/Asu3Qy0sXdrnyD6lbvpzGY0hQnObw/HhDg7cQKBgQD5G6vdrHRrQXtxtq/+O5ONPRwIL6zVvNeJDYOIMrm1fV4I14E4hMOJHmrtyzLLutjxqtmCBPtkVGReaNT/u4cn6LBtSTy+ZUe4Mq5NYN5WaaOfQmVlZ0E8BZTdwlFkbaJNzALss8+GyEiAwgnbsHWhSirxT4mit/P0SDKYEasEOQKBgQD1PEBMk6QWt3uxv4c/00Q+NCcHFHcUssI7f7LIeMbDSLASbeCTsEk1oMRnsJ7IS3yD97qkp7uKUyULzX575V1Lj757M0fZWtAet9FWTBQP+oNwRLl7mH19bAuMyx6aZ631Wh1h5TJfrqALe7MOrkL7D+Cd3nhkMGx3D3NjIr54awKBgCrjE7THYwewL2OFc0lO0nlngvL52kS2DVmAJRwGt6hCXDUjfRDQ8qUhwoEMEcO3eHAq3OWgm/NLADiszbb1fzBkxDMcf8O7xhw1RYL24XB5IX1ivfg2TanawCVptf+XTHEeZYaA8oKe6rSYM4BKIgZRsZD4A5crGmn9IBDEQfApAoGBAIzs09JtoYUAac+qTbGq2XOZirfx1cCKPT3t0zKK3UXJlozwoXadfmSX/2XKxGQ7pNE9Yf9O+GG0B/zxWPcfxm4uq3qm7GoGWsTcQysBSyInhrLUe3aAGdUiary82NhILlppL6tbB4ielBAlRK9yCsG1zRFLkAmbHimJMnjMtYIDAoGAVXZVAv+T050C5FdA6Ch4/a0Hv4VNyKUtUIl7dHQJunSXgjJFEMARcLvlhWfFBxK2tfADW/M9nNSQkWJb/a+lLN8EhXXKmC9bslU2U0ndD08gH9E0S+MqRLeejY7NQ2uxgOp1z7XXawaTKpnXqcDUtk8aWewOYKZEaUdAhqRKP2s=";

    const appKey = "202402011202541471740198912";

    /**
     * Get signature
     * @param $appKey
     * @param $privateKey
     * @param $timestamp
     * @return String
     */
    public function getSign($appKey, $privateKey, $timestamp)
    {
        $contentForSign = "appKey={$appKey}&signType=rsa2&timestamp={$timestamp}";

        return $this->sign($contentForSign, $privateKey);
    }

    /**
     * Verify signature
     * @param $appKey
     * @param $sign
     * @param $timestamp
     */
    public function verifyRes($appKey, $sign, $timestamp)
    {
        $contentForSign = "appKey={$appKey}&signType=rsa2&timestamp={$timestamp}";

        print_r($this->verify($contentForSign, $sign, self::publicKey));
    }

    /**
     * Get millisecond timestamp
     * @return int
     */
    public function getMillisecond()
    {
        list($s1, $s2) = explode(' ', microtime());
        return intval((float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000));
    }


    private function verify($content, $sign, $publicKey)
    {
        $publicKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($publicKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";

        $key = openssl_get_publickey($publicKey);
        $ok = openssl_verify($content, base64_decode($sign), $key, 'SHA256');
        openssl_free_key($openssl_public_key);
        return $ok ? true : false;
    }


    private function sign($content, $privateKey)
    {
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($privateKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        $key = openssl_get_privatekey($privateKey);

        $private_key = openssl_pkey_get_private($key);
        if (!$private_key) {
            return 'The secret key is incorrect';
        }
        openssl_sign($content, $signature, $private_key, 'sha256');
        openssl_free_key($private_key);  //释放密钥资源
        $sign = base64_encode($signature);  //加密的签名
        return $sign;
    }
}



// test code
//$rasUtil = new RsaUtil();
////Get millisecond timestamp
//$timestamp = $rasUtil->getMillisecond();
////Get signature
//$sign = $rasUtil->getSign(RsaUtil::appKey, RsaUtil::privateKey, $timestamp);
////Verify signature
//$rasUtil->verifyRes(RsaUtil::appKey, $sign, "{$timestamp}");
