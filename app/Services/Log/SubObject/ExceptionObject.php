<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/8/18
 * Time: 下午1:27
 */

namespace App\Services\Log\SubObject;

class ExceptionObject extends AbstractSubObject
{
    protected $_attributes = [
        'id' => '',
        'message' => '',
        'file' => '',
        'code' => '',
        'line' => '',
    ];

    protected function __construct($config = [])
    {
        if ($config instanceof \Exception) {
            parent::__construct([
                'message' => $config->getMessage(),
                'file' => $config->getFile(),
                'code' => $config->getCode(),
                'line' => $config->getLine(),
            ]);
        } else {
            parent::__construct($config);
        }

        // 增加异常Hash值，方便开发人员排查
        $this->_attributes['id'] = md5(
            $this->_attributes['message'] . '-'
            . $this->_attributes['file'] . '-'
            . $this->_attributes['code'] . '-'
            . $this->_attributes['line'] . '-'
        );
    }
}
