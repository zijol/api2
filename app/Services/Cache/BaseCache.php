<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-28
 * Time: 22:00
 */

namespace App\Services\Cache;

use Illuminate\Support\Facades\Redis;

class BaseCache
{
    /**
     * 链接池名称
     */
    const CONNECTION_NAME = 'default';

    /**
     * 缓存命名
     */
    const CACHE_NAME = 'example_connection';

    /**
     * 缓存超时时间（秒）
     */
    const CACHE_EXPIRE = 5 * 60;

    /**
     * @var array 依赖
     */
    protected $_relies = [

    ];

    /**
     * @var \Illuminate\Redis\Connections\Connection
     */
    private $_cache = null;

    /**
     * BaseCache constructor.
     * @param array $relies
     */
    public function __construct(...$relies)
    {
        $this->_relies = $relies;
        $this->_cache = Redis::connection(static::CONNECTION_NAME);;
    }


    /**
     * 获取缓存
     *
     * @return mixed
     */
    public function get()
    {
        $cacheData = $this->_cache->get($this->_key());
        $cacheData = json_decode($cacheData, true);

        if ($cacheData['type'] == 'array') {
            return json_decode($cacheData['value'], true);
        } elseif ($cacheData['type'] == 'object') {
            return json_decode($cacheData['value']);
        } else {
            return $cacheData['value'];
        }
    }

    /**
     * 设置缓存
     *
     * @param string $data
     * @return bool
     */
    public function set($data = '')
    {
        if (is_array($data)) {
            $cacheData = json_encode([
                'type' => 'array',
                'value' => json_encode($data, JSON_UNESCAPED_UNICODE)
            ], JSON_UNESCAPED_UNICODE);
        } else if (is_resource($data)) {
            return false;
        } else if (is_object($data)) {
            $cacheData = json_encode([
                'type' => 'object',
                'value' => json_encode($data, JSON_UNESCAPED_UNICODE)
            ], JSON_UNESCAPED_UNICODE);
        } else {
            $cacheData = json_encode([
                'type' => 'normal',
                'value' => $data
            ], JSON_UNESCAPED_UNICODE);
        }

        $this->_cache->setex(
            $this->_key(),
            static::CACHE_EXPIRE,
            $cacheData
        );

        return true;
    }

    /**
     * 删除缓存
     *
     * @return bool
     */
    public function del()
    {
        $this->_cache->del([$this->_key()]);
        return true;
    }

    /**
     * 如果缓存不再，设置缓存并返回；如果缓存在，获取缓存
     *
     * @param callable $callback
     * @return mixed
     */
    public function getWithSet(callable $callback)
    {
        $cacheGet = $this->get();

        // 如果没有获取到缓存，设置缓存，并且得到返回值
        if (is_null($cacheGet)) {
            $callbackData = call_user_func($callback);
            $this->set($callbackData);
            return $callbackData;
        }

        return $cacheGet;
    }


    /**
     * 根据缓存依赖，获取缓存键
     *
     * @return string
     */
    private function _key()
    {
        $key = static::CONNECTION_NAME . "&_";

        foreach ($this->_relies as $relyKey => $rely) {
            $key .= $relyKey . ':' . $rely;
        }

        $key .= '_&' . static::CACHE_NAME;

        return $key;
    }
}
