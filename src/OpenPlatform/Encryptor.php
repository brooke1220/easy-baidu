<?php

namespace EasyBaidu\OpenPlatform;

use EasyWeChat\Kernel\Encryptor as BaseEncryptor;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use EasyWeChat\Kernel\Support\AES;
use EasyWeChat\Kernel\Exceptions\RuntimeException;

class Encryptor extends BaseEncryptor
{
    /**
     * 对密文进行解密
     * @param $encrypted
     * @return bool|string
     * @throws Exception
     */
     public function decrypt($encrypted, $msgSignature, $nonce, $timestamp, $isCheckClientId = false): string
     {
         $signature = $this->signature($this->token, $timestamp, $nonce, $encrypted);

        if ($signature !== $msgSignature) {
            throw new RuntimeException('Invalid Signature.', self::ERROR_INVALID_SIGNATURE);
        }

         try {
             // 使用BASE64对需要解密的字符串进行解码
             $ciphertextDec = base64_decode($encrypted);
             $iv = substr($this->aesKey, 0, 16);
             // 解密
             $decrypted = openssl_decrypt($ciphertextDec, 'aes-256-cbc', $this->aesKey, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
         } catch (Exception $e) {
             throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
         }
         try {
             // 去除补位字符
             $result = $this->pkcs7Unpad($decrypted);
             // 去除16位随机字符串,网络字节序和clientId
             if (strlen($result) < 16) {
                 throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
             }
             $content = substr($result, 16, strlen($result));
             $lenList = unpack("N", substr($content, 0, 4));
             $xmlLen = $lenList[1];
             $xmlContent = substr($content, 4, $xmlLen);
             $fromClientId = substr($content, $xmlLen + 4);
         } catch (Exception $e) {
             throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
         }

         if ($isCheckClientId && ($fromClientId != $this->appId)) {
             throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
         }

         return $xmlContent;
     }
}
