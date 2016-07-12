<?php

namespace Commander;

use Exception;
use Requests;

class Base {

    public $options;

    public function __construct($options=[]) {
        $this->options = $options;
    }

    public function getParam($name) {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * Выполнить запрос
     * @param $url
     * @param string $type
     * @param array $data
     * @return array
     */
    public function request($url, $type=Requests::GET, $data=[]) {

        $headers     = [];
        $options     = [];
        $contentType = false;

        $request = Requests::request($url, $headers, $data, $type, $options);

        $code        = $request->status_code;
        $contentType = $request->headers['content-type'];
        $body        = $request->body;

        if ($code !== 200) throw new Exception("Request Failed", $code);
        
        if (strpos($contentType, 'json') !== false) {
            $response = json_decode($body, true);
        } else {
            $response = $body;
        }
        
        return [
            "response" => $response,
            "content-type" => $contentType,
            "code" => $code,
            "raw_body" => $body
        ];
    }

}