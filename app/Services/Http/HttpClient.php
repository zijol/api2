<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/3/4
 * Time: 14:24
 */

namespace App\Services\Http;

use App\Exceptions\ForbiddenException;
use App\Exceptions\SystemException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    private $base_uri = '';
    private $timeout = 5.0;
    private $headers = [];
    private $http_errors = true;

    public function __construct($base_uri, $headers = [], $timeout = 5.0, $http_errors = true)
    {
        $this->base_uri = $base_uri;
        $this->headers = $headers;
        $this->timeout = $timeout;
        $this->http_errors = $http_errors;
    }

    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->base_uri,
            'timeout' => $this->timeout,
            'headers' => $this->headers,
            'http_errors' => $this->http_errors
        ]);
    }

    /**
     * @param $uri
     * @param $params
     * @param $format
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function post($uri, $params, $format = 'form_params')
    {
        return $this->send('POST', $uri, $params, $format);
    }

    /**
     * @param $uri
     * @param $params
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function get($uri, $params)
    {
        return $this->send('GET', $uri, $params);
    }

    /**
     * @param $uri
     * @param $params
     * @param $format
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function put($uri, $params, $format = 'form_params')
    {
        return $this->send('PUT', $uri, $params, $format);
    }

    /**
     * @param $uri
     * @param $params
     * @return string
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function delete($uri, $params)
    {
        return $this->send('DELETE', $uri, $params);
    }

    /**
     * send 方法
     *
     * @param $method
     * @param $uri
     * @param $params
     * @param $format
     * @return mixed
     * @throws ForbiddenException
     * @throws SystemException
     */
    public function send($method, $uri, $params, $format = 'form_params')
    {
        $client = $this->getClient();
        $requestOptions = [];

        // 如果是DELETE | GET
        if (in_array(strtoupper($method), ['GET', 'DELETE'])) {
            $requestOptions['query'] = $params;
            $realMethod = strtoupper($method);

            // 如果是DELETE | GET
        } elseif (in_array(strtoupper($method), ['POST', 'PUT'])) {
            if (in_array($format, ['body', 'json', 'form_params', 'multipart'])) {
                $requestOptions[$format] = $params;
            } else {
                $requestOptions['form_params'] = $params;
            }
            $realMethod = strtoupper($method);

            // 其他都使用GET
        } else {
            $requestOptions['query'] = $params;
            $realMethod = 'GET';
        }

        try {
            return $this->_response($client->request($realMethod, $uri, $requestOptions));
            // 服务端错误 5xx
        } catch (ServerException $serverException) {
            if ($serverException->hasResponse()) {
                $response = $serverException->getResponse();
                $httpCode = $response->getStatusCode();
            }
            $this->_response(
                $response ?? null,
                new SystemException('服务器错误', null, null, null, $httpCode ?? null)
            );

            // 客户端错误 4xx
        } catch (ClientException $clientException) {
            if ($clientException->hasResponse()) {
                $response = $clientException->getResponse();
                $httpCode = $response->getStatusCode();
            }
            $this->_response(
                $response ?? null,
                new ForbiddenException('请求错误', null, null, null, $httpCode ?? null)
            );

            // 请求过程中网络错误
        } catch (RequestException $requestException) {
            if ($requestException->hasResponse()) {
                $response = $requestException->getResponse();
                $httpCode = $response->getStatusCode();
            }
            $this->_response(
                $response ?? null,
                new ForbiddenException('网络错误', null, null, null, $httpCode ?? null)
            );

            // 其他未知错误
        } catch (GuzzleException $exception) {
            $this->_response(
                null,
                new SystemException('系统错误 ' . $exception->getMessage())
            );
        }
    }

    /**
     * 返回最终结果
     *
     * @param $response
     * @param $exception
     * @return array
     */
    private function _response($response, $exception = null)
    {
        if ($response instanceof ResponseInterface) {
            return [
                'status' => $response->getStatusCode(),
                'headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
                'content' => $response->getBody()->getContents(),
                'exception' => $exception,
            ];
        } else {
            return [
                'status' => $httpCode ?? null,
                'headers' => $headers ?? null,
                'content' => $content ?? null,
                'exception' => $exception,
            ];
        }
    }
}
