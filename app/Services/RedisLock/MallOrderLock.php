<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/5/19
 * Time: 14:26
 */

namespace App\Services\RedisLock;

class MallOrderLock extends RedisLock
{
    const MILLISECONDS_EXPIRE_TTL = 5000;
    private $appId = '';
    private $orderId = '';

    public function __construct($appId, $orderId)
    {
        $this->appId = $appId;
        $this->orderId = $orderId;
        parent::__construct();
    }

    public function getLockKey()
    {
        return "app:{$this->appId}&order:{$this->orderId}&mall_order_lock";
    }
}
