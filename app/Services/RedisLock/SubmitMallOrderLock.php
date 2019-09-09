<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 2019/5/19
 * Time: 14:26
 */

namespace App\Services\RedisLock;

class SubmitMallOrderLock extends RedisLock
{
    const MILLISECONDS_EXPIRE_TTL = 10;
    const LOCKED_TIP_MSG = '您有正在提交中的订单，请稍后再试';
    private $appId = '';
    private $userId = '';

    public function __construct($appId, $userId)
    {
        $this->appId = $appId;
        $this->userId = $userId;
        parent::__construct();
    }

    public function getLockKey()
    {
        return "app:{$this->appId}&user:{$this->userId}&submit_mall_order_lock";
    }
}
