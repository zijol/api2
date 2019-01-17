<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/18
 * Time: 下午1:26
 */

namespace App\Services\Log\SubObject;

/**
 * Class CustomObject
 * 用于任何自定义对象
 * @package Pingpp\Log\DashboardLog\SubObject
 */
class CustomObject extends AbstractSubObject
{
    protected $_attributes = [];
    protected $_allowAttributeExtra = true;
}
