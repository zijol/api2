<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-05-28
 * Time: 23:05
 */

namespace App\Services\Cache;

class DyCookiesCache extends BaseCache
{
    const CACHE_NAME = 'dy_cookies';
    protected $_relies = [];
}