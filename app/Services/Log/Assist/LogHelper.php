<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/22
 * Time: 上午10:33
 */

namespace App\Services\Log\Assist;

use App\Services\Helper\IDGenerator;

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

    private $_commitId = '';
    private $_tagNo = '';

    /**
     * 初始化数据
     *
     * LogHelper constructor.
     * @param array $config
     * @throws \App\Exceptions\SystemException
     */
    private function __construct($config = [])
    {
        $this->_id = IDGenerator::uuid1();
        $this->_initMegaSecond = $this->_getMegaSecond();
    }

    /**
     * 拿到唯一实例
     *
     * @param array $config
     * @return LogHelper|null
     * @throws \App\Exceptions\SystemException
     */
    public static function instance($config = [])
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self($config);
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
     * 获取commit_id
     *
     * @return \Illuminate\Config\Repository|int|mixed
     */
    public function getCommitId()
    {
        if (empty($this->_commitId)) {
            $this->_commitId = config('app.commit_id', "");
        }

        return $this->_commitId;
    }

    /**
     * 获取 tag no
     * @return \Illuminate\Config\Repository|int|mixed
     */
    public function getTagNo()
    {
        if (empty($this->_tagNo)) {
            $this->_tagNo = config('app.tag_no', "");
        }

        return $this->_tagNo;
    }

    /**
     * 重新初始化
     *
     * @throws \App\Exceptions\SystemException
     */
    public function init()
    {
        $this->_id = IDGenerator::uuid1();
        $this->_initMegaSecond = $this->_getMegaSecond();
        $this->_serialNumber = 0;
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
            case 'tag_no':
                return $this->getTagNo();
            case 'commit_id':
                return $this->getCommitId();
            default :
                return null;
        }
    }
}
