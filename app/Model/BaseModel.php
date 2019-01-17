<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/24
 * Time: 17:36
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * @var bool $live_mode
     */
    protected static $live_mode = true;

    /**
     * @var string 测试表前缀
     */
    protected $test_table_prefix = '';

    /**
     * @var string test表后缀
     */
    protected $test_table_suffix = '';

    /**
     * 设置live mode
     *
     * @param boolean $liveMode
     */
    public static function switchMode($liveMode = true)
    {
        static::$live_mode = boolval($liveMode);
    }

    /**
     * @return string test表
     */
    protected function _testTable()
    {
        return $this->test_table_prefix . $this->table . $this->test_table_suffix;
    }

    /**
     * 获取表名
     *
     * @return string
     */
    public function getTable()
    {
        if (static::$live_mode) {
            return parent::getTable();
        } else {
            return $this->_testTable();
        }
    }
}
