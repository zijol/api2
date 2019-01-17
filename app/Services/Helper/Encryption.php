<?php

namespace App\Services\Helper;

class Encryption
{
    const MODE_GCM = 'id-aes256-GCM';

    /**
     * version: AES_v1
     *
     * mode: Cipher::MODE_GCM
     * tag length: 16
     * IV length: 12
     * IV: chr(0) * 12
     * key size: 256 bit
     * aad: ''
     * pbkdf2 iterations: 5000
     * pbkdf2 key algo: sha256
     * pbkdf2 salt length: 32
     */
    private static $mode = self::MODE_GCM;
    private static $keySize = 256;
    private static $version = 'AES_v1';
    private static $tagLen = 16;
    private static $IVlength = 12;

    /**
     * 密码加密的参数
     */
    private static $ev = 'ev2';
    private static $evMark = ':';
    private static $evSaltLen = 16;

    public function __construct()
    {
        if (PHP_VERSION_ID < 70100) {
            exit('不支持的 PHP 版本， 请升级！');
        }
    }

    /**
     * @param $pt
     * @param $key
     * @param null $iv
     * @param string $aad
     * @return array
     */
    public static function gcmEncrypt($pt, $key, $iv = null, $aad = '')
    {
        if ($iv === null) {
            $iv = self::zeroIV(self::$IVlength);
        }
        $ct = openssl_encrypt($pt, self::$mode, $key, OPENSSL_RAW_DATA, $iv, $tag, $aad, self::$tagLen);

        return [$ct, $tag];
    }

    /**
     * @param $ct
     * @param $key
     * @param $iv
     * @param $aad
     * @param $tag
     * @return string
     */
    public static function gcmDecrypt($ct, $key, $iv, $aad, $tag)
    {
        if ($iv === null) {
            $iv = self::zeroIV(self::$IVlength);
        }

        return openssl_decrypt($ct, self::$mode, $key, OPENSSL_RAW_DATA, $iv, $tag, $aad);
    }

    /**
     * @param $length
     * @return string
     */
    private static function zeroIV($length)
    {
        return str_repeat(chr(0), $length);
    }

    /**
     * @param $password
     * @param $key
     * @return string
     */
    public static function encryptPassword($password, $key)
    {
        $salt = substr(hash('sha512', str_random(self::$evSaltLen), true), 0, self::$evSaltLen);
        $key_hash = substr(hash('sha512', $key . $salt, true), 0, self::$keySize / 8);
        list($ct, $tag) = self::gcmEncrypt($password, $key_hash);

        return self::$ev . self::$evMark . base64_encode($salt . $ct . $tag);
    }

    /**
     * @param $data
     * @param $key
     * @param bool $unknown_prefix_return_data
     * @return null|string
     */
    public static function decryptPassword($data, $key, $unknown_prefix_return_data = false)
    {
        $exploded_data = explode(self::$evMark, $data);
        $ev = $exploded_data[0];
        if ($ev !== self::$ev) {
            return $unknown_prefix_return_data === false ? null : $data;
        }
        $data = base64_decode($exploded_data[1]);
        $salt = substr($data, 0, self::$evSaltLen);
        $encrypted_data = substr($data, self::$evSaltLen, -self::$tagLen);
        $tag = substr($data, -self::$tagLen);
        $key_hash = substr(hash('sha512', $key . $salt, true), 0, self::$keySize / 8);

        return self::gcmDecrypt($encrypted_data, $key_hash, null, '', $tag);
    }
}
