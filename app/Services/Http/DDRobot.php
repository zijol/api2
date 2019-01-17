<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 18/12/28
 * Time: 10:09
 */

namespace App\Services\Http;

/**
 * 目前只支持钉钉自定义机器人
 *
 * Class DingDingRobot
 * @package Pingpp\Service\HttpThirdParty
 */
class DDRobot
{
    /**
     * @var resource
     */
    private $ch;
    /**
     * @var DDRobot
     */
    private static $instance;

    /**
     * DingDingRobot constructor.
     * @param $token
     */
    private function __construct(string $token)
    {
        $this->ch = curl_init("https://oapi.dingtalk.com/robot/send?access_token=" . $token);

        curl_setopt_array($this->ch, [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        ]);
    }

    /**
     * @param $token
     *
     * @return DDRobot
     */
    public static function getInstance(string $token)
    {
        if (!(static::$instance instanceof DingDingRobot))
            static::$instance = new static($token);

        return static::$instance;
    }

    /**
     * 发送文本
     *
     * @param string $textContent
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return mixed
     */
    public function sendText(?string $textContent, array $atMobiles = [], bool $isAtAll = false)
    {
        $data = json_encode([
            'msgtype' => 'text',
            'text' => $textContent,
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll
            ]
        ]);
        return $this->_send($data);
    }

    /**
     * 发送链接
     *
     * @param string $text
     * @param string $title
     * @param string $picUrl
     * @param string $messageUrl
     * @return mixed
     */
    public function sendLink(string $text, string $title, string $picUrl, string $messageUrl)
    {
        $data = json_encode([
            'msgtype' => 'link',
            'link' => [
                'text' => $text,
                'title' => $title,
                'picUrl' => $picUrl,
                'messageUrl' => $messageUrl
            ]
        ]);
        return $this->_send($data);
    }

    /**
     * 发送Markdown
     *
     * @param string $title
     * @param string $mdText
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return mixed
     */
    public function sendMarkdown(string $title, string $mdText, array $atMobiles = [], bool $isAtAll = false)
    {
        $data = json_encode([
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $mdText,
            ],
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll
            ]
        ]);
        return $this->_send($data);
    }

    /**
     * 发送 actionCard
     *
     * @param string $title
     * @param string $text
     * @param string $singleTitle
     * @param string $singleURL
     * @param bool $hideAvatar
     * @param bool $btnOrientation
     * @return mixed
     */
    public function sendActionCard(string $title, string $text,
                                   string $singleTitle, string $singleURL,
                                   bool $hideAvatar = false, bool $btnOrientation = false
    )
    {
        $data = json_encode([
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL,
                'hideAvatar' => $hideAvatar,
                'btnOrientation' => $btnOrientation,
            ]
        ]);
        return $this->_send($data);
    }

    /**
     * 发送feedCard
     *
     * @param array $links as ['title'=>'', 'messageURL'=>'', 'picURL'=>'']
     * @return mixed
     */
    public function sendFeedCard(array $links = [])
    {
        $data = json_encode([
            'msgtype' => 'feedCard',
            'links' => $links
        ]);
        return $this->_send($data);
    }

    /**
     * 真正发送数据
     *
     * @param string $data
     * @return mixed
     */
    private function _send($data = "")
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        return curl_exec($this->ch);
    }

    /**
     * 释放句柄
     */
    function __destruct()
    {
        curl_close($this->ch);
    }
}
