<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/5/19
 * Time: 14:26
 */

namespace App\Services\RedisLock;

use Common\Exceptions\ForbiddenException;
use Illuminate\Support\Facades\Redis;

abstract class RedisLock
{
    // 锁的有效时间（ms）
    const MILLISECONDS_EXPIRE_TTL = 1000;
    const LOCKED_TIP_MSG = '系统繁忙，请稍后再试';
    const LOCKED_ERR_CODE = null;

    const REDIS_NAME = 'default';
    const LOCK_SUCCESS = 'OK';
    const IF_NOT_EXIST = 'NX';
    const MILLISECONDS_EXPIRE_TIME = 'PX';
    const RELEASE_SUCCESS = 1;
    private $lockKey = 'redis_lock';

    /**
     * @var null | \Illuminate\Redis\Connections\Connection
     */
    protected $redis = null;

    /**
     * RLock constructor.
     *
     * 获取redis
     */
    public function __construct()
    {
        $this->redis = Redis::connection(static::REDIS_NAME);
        $this->lockKey = $this->getLockKey();
    }

    /**
     * @return string 获取缓存键
     */
    abstract function getLockKey();

    /**
     * 获取锁
     *
     * @return bool
     */
    public function get()
    {
        $result = $this->redis->set(
            $this->lockKey,
            "using",
            static::MILLISECONDS_EXPIRE_TIME,
            static::MILLISECONDS_EXPIRE_TTL,
            static::IF_NOT_EXIST);

        return static::LOCK_SUCCESS === (string)$result;
    }

    /**
     * 释放锁
     *
     * @return bool
     */
    public function release()
    {
        $lua = "if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end";
        $result = $this->redis->eval($lua, 1, $this->lockKey, 'using');

        return static::RELEASE_SUCCESS === $result;
    }

    /**
     * @return bool
     * @throws ForbiddenException
     */
    public function safeGet()
    {
        if (!$this->get()) {
            throw new ForbiddenException(static::LOCKED_TIP_MSG);
        }

        return true;
    }

    /**
     * 断开redis连接
     */
    public function __destruct()
    {
        $this->redis->disconnect();
    }
}
