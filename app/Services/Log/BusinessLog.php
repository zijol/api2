<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/25
 * Time: 17:41
 */

namespace App\Services\Log;

use App\Services\Log\SubObject\CustomObject;
use App\Services\Log\SubObject\ExceptionObject;

/**
 * Class HttpLog
 *
 * @package App\Services\Log
 */
class BusinessLog extends AbstractLog
{
    protected static $_logPath = '';

    protected $_logType = 'business_log';

    protected $_typeContext = [
        'message' => ''
    ];

    /**
     * @return AbstractLog
     */
    public static function getInstance()
    {
        if (empty(static::$_logPath)) {
            static::$_logPath = config('logging.business_log_path') ?? storage_path('logs') . '/business.log';
        }
        return parent::getInstance();
    }

    /**
     * 日志
     * @param mixed $message
     * @param string $module
     * @return bool
     */
    public static function Log($message, $module = null)
    {
        try {
            static::getInstance()
                ->delContext()
                ->setContext([
                    'message' => json_encode(CustomObject::normalize($message), JSON_UNESCAPED_UNICODE)
                ])->info($module ?? "BusinessLog");
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * 支持Exception 的error日志
     *
     * @param mixed $message
     * @param string $module
     * @param null $exception
     * @return bool|AbstractLog
     */
    public static function ErrorLog($message, $module, $exception = null)
    {
        try {
            $content = [
                'message' => json_encode(CustomObject::normalize($message), JSON_UNESCAPED_UNICODE),
            ];
            if ($exception instanceof \Exception) {
                $content['exception'] = ExceptionObject::normalize($exception);
            }

            static::getInstance()
                ->delContext()
                ->setContext($content)
                ->error($module ?? "BusinessLog");
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * 支持Exception 的 warning 日志
     *
     * @param mixed $message
     * @param string $module
     * @param null $exception
     * @return bool|AbstractLog
     */
    public static function WarningLog($message, $module, $exception = null)
    {
        try {
            $content = [
                'message' => json_encode(CustomObject::normalize($message), JSON_UNESCAPED_UNICODE),
            ];
            if ($exception instanceof \Exception) {
                $content['exception'] = ExceptionObject::normalize($exception);
            }

            static::getInstance()
                ->delContext()
                ->setContext($content)
                ->warning($module ?? "BusinessLog");
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
