<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/22
 * Time: 上午10:33
 */

namespace App\Services\Log\Assist;

/**
 * Class LogHelper
 * @package Pingpp\Framework\Log\Assist
 * @property int exec_millisecond 过程毫秒数
 * @property string unique_id 唯一ID
 * @property int serial_number 自增序号
 */
class LogHelper
{
    private static $_instance = null;

    // 唯一ID
    private $_id = '';
    // 序号
    private $_serialNumber = 0;
    // 初始化时候的兆秒数
    private $_initMegaSecond = 0;

    /**
     * 初始化数据
     *
     * LogHelper constructor.
     */
    private function __construct()
    {
        $this->_id = $this->_id();
        $this->_initMegaSecond = $this->_getMegaSecond();
    }

    /**
     * 拿到唯一实例
     *
     * @return null|LogHelper
     */
    public static function instance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 获取兆秒数
     *
     * @return float
     */
    private function _getMegaSecond()
    {
        list($mSec, $sec) = explode(' ', microtime());
        return ($mSec + $sec) * 1000000;
    }

    /**
     * 获取唯一ID
     *
     * @param int $length
     * @param string $prefix
     * @return bool|string
     */
    private function _id($length = 24, $prefix = 'log_')
    {
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $key = "Pingxx";
        $str = md5(uniqid(rand(), TRUE));
        $id = $prefix;
        $hash = md5($key . $str);
        $len = strlen($hash);
        for ($i = 0; $i < 4; $i++) {
            $hash_piece = substr($hash, $i * $len / 4, $len / 4);
            $hex = hexdec($hash_piece) & 0x3fffffff;
            for ($j = 0; $j < 6; $j++) {
                $id .= $charset[$hex & 0x0000003d];
                $hex = $hex >> 5;
            }
        }
        return substr($id, 0, $length + strlen($prefix));
    }

    /**
     * 实现属性获取
     *
     * @param $name
     * @return bool|float|int|null|string
     */
    public function __get($name)
    {
        switch (strtolower($name)) {
            case 'exec_millisecond':
                return round(($this->_getMegaSecond() - $this->_initMegaSecond) / 1000, 0);
            case 'unique_id':
                return $this->_id;
            case 'serial_number':
                return ++$this->_serialNumber;
            default :
                return null;
        }
    }
}
