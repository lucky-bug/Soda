<?php

namespace Soda\Http;

use Soda\Core\Base;
use Soda\Validation\Validator;

class Request extends Base
{
    const QUERY_URL_PARAM = 'url';

    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_TRACE = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';

    /**
     * @getter
     * @setter
     */
    protected $url;
    
    /**
     * @getter
     * @setter
     */
    protected $method;
    
    /**
     * @getter
     * @setter
     */
    protected $query;
    
    /**
     * @getter
     * @setter
     */
    protected $request;
    
    /**
     * @getter
     * @setter
     */
    protected $server;

    public static function fromGlobals()
    {
        return new static([
            'url' => trim($_GET[self::QUERY_URL_PARAM] ?? explode('?', $_SERVER['REQUEST_URI'])[0] ?? '', '/'),
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'query' => $_GET,
            'request' => $_POST,
            'server' => $_SERVER,
        ]);
    }

    public function getQueryValue(string $fieldName, $default = null)
    {
        return $this->query[$fieldName] ?? $default;
    }

    public function getRequestValue(string $fieldName, $default = null)
    {
        return $this->request[$fieldName] ?? $default;
    }

    public function getServerValue(string $fieldName, $default = null)
    {
        return $this->server[$fieldName] ?? $default;
    }

    public function get(string $fieldName, $default = null) {
        return $this->method === 'GET'
            ? ($this->query[$fieldName] ?? $default)
            : ($this->request[$fieldName] ?? $default)
        ;
    }

    public function validate(array $rules) {
        $data = $this->method === 'GET' ? $this->query : $this->request;
        $validator = new Validator([
            'data' => $data,
            'rules' => $rules,
        ]);

        return $validator->validate();
    }
}
