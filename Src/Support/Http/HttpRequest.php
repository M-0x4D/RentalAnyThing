<?php

namespace MvcCore\Rental\Support\Http;

use MvcCore\Rental\Exceptions\InvalidRequestException;
use MvcCore\Rental\Exceptions\UnsupportedAuthenticationType;
use MvcCore\Rental\Exceptions\UnsupportedRequestType;
use MvcCore\Rental\Support\Debug\Debugger;
use MvcCore\Rental\Controllers\Frontend\ReservationsController;
use MvcCore\Rental\Helpers\ArrayToJson;

class HttpRequest
{
    /**
     * curl instance
     *
     * @var [curl]
     */
    private $curl;

    /**
     * headers of the request
     *
     * @var array
     */
    private array $headers;

    /**
     * baseUrl of the request
     *
     * @var array
     */
    private string $baseUrl;

    public function __construct(string $baseUrl, array $headers = ['Content-type' => 'application/json'])
    {
        $this->curl = curl_init();
        $this->headers = $headers;
        $this->baseUrl = $baseUrl;
    }

    /**
     * get Request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return void
     */
    public function get(string $url, string $authType, $data = [], array $headers = ['Content-type' => 'application/json'])
    {
        $url = $this->baseUrl . $url;
        $this->headers = $headers;
        return $this->send_request($url, $data, 'GET', $authType);
    }

    /**
     * POST Request
     *
     * @param string $url
     * @param string $data
     * @param array $headers
     * @return void
     */
    public function post(string $url, string $authType = '',  $data = '', array $headers = ['Content-Type' => 'application/json'])
    {

        $url = $this->baseUrl . $url;
        $this->headers = $headers;
        // Debugger::die_and_dump($this->send_request($url, $data, 'POST', $authType));
        return $this->send_request($url, $data, 'POST', $authType);
    }

    /**
     * PATCH Request
     *
     * @param string $url
     * @param string $data
     * @param array $headers
     * @return void
     */
    public function patch(string $url, string $authType, $data = '', array $headers = ['Content-type' => 'application/json'])
    {
        $url = $this->baseUrl . $url;
        $this->headers = $headers;
        return $this->send_request($url, $data, 'PATCH', $authType);
    }

    /**
     * PUT Request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return void
     */
    public function put(string $url, string $authType, $data = [], array $headers = ['Content-type' => 'application/json'])
    {
        $url = $this->baseUrl . $url;
        $this->headers = $headers;
        return $this->send_request($url, $data, 'PUT', $authType);
    }

    /**
     * DELETE Request
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return void
     */
    public function delete(string $url, string $authType, $data = [], array $headers = ['Content-type' => 'application/json'])
    {
        $url = $this->baseUrl . $url;
        $this->headers = $headers;
        return $this->send_request($url, $data, 'DELETE', $authType);
    }

    /**
     * for sending request 
     *
     * @param string $data
     * @param  $token
     * @return array $response
     */
    public function send_request(string $url, $data, string $method, string $authType)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        switch ($method) {
            case 'POST':
            case 'PUT':
            case 'PATCH':
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
                break;
            case 'GET':
            case 'DELETE':
                break;
            default:
                throw new UnsupportedRequestType();
        }

        switch ($authType) {
            
            case 'Bearer':
                curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                break;
            case 'Basic':
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
                break;
            case 'Guest':
                curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
                break;
            case '':
                break;
            default:
                throw new UnsupportedAuthenticationType();
        }

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        if (!$response) {
            throw new InvalidRequestException();
        }
        return isset($this->headers['Content-Type']) && $this->headers['Content-Type'] === 'application/xml' ? $response : json_decode($response, true);
    }
}