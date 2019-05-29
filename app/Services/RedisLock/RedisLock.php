<?php

namespace App\Services\RedisLock;

use App\Exceptions\ForbiddenException;
use Illuminate\Support\Facades\Redis;

class RedisLock
{
    /**
     * 链接池名称
     */
    const CONNECTION_NAME = 'default';

    /**
     * 锁名字，根据业务保证唯一
     */
    protected const LOCK_KEY = 'redis_lock';

    /**
     * 锁的有效时间（ms）
     */
    protected const MILLISECONDS_EXPIRE_TTL = 1000;

    private const LOCK_SUCCESS = 'OK';
    private const IF_NOT_EXIST = 'NX';
    private const MILLISECONDS_EXPIRE_TIME = 'PX';
    private const RELEASE_SUCCESS = 1;

    /**
     * 获取锁
     *
     * @param array $relies
     * @return bool
     */
    public static function get(array $relies)
    {
        $redis = Redis::connection(static::CONNECTION_NAME);

        $result = $redis->set(
            static::LOCK_KEY,
            self::requestId($relies),
            self::MILLISECONDS_EXPIRE_TIME,
            static::MILLISECONDS_EXPIRE_TTL,
            self::IF_NOT_EXIST);

        return self::LOCK_SUCCESS === (string)$result;
    }

    /**
     * 释放锁
     *
     * @param array $relies
     * @return bool
     */
    public static function release(array $relies)
    {
        $redis = Redis::connection(static::CONNECTION_NAME);

        $lua = "if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end";
        $result = $redis->eval($lua, 1, static::LOCK_KEY, self::requestId($relies));

        return self::RELEASE_SUCCESS === $result;
    }

    /**
     * @param array $relies
     * @return bool
     * @throws ForbiddenException
     */
    public static function safeGet(array $relies)
    {
        if (!self::get($relies)) {
            throw new ForbiddenException('系统繁忙，请稍后再试');
        }

        return true;
    }

    /**
     * 根据依赖生成 requestId
     *
     * @param array $relies
     * @param string $split
     * @param bool $useReliesKey
     * @return string
     */
    private static function requestId(array $relies, $split = '&', $useReliesKey = false)
    {
        $temp = [];
        sort($relies);
        foreach ($relies as $k => $v) {
            $useReliesKey
                ? array_push($temp, $v)
                : array_push($temp, $k . ':' . $v);
        }
        return 'redis_lock:' . md5(implode($split, $temp));
    }
}