<?php

namespace Soda\Http;

use Soda\Core\Base;
use Soda\Validation\Validator;

class Request extends Base
{
    const QUERY_URL_PARAM = 'url';

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

    public function getQueryValue($fieldName)
    {
        return $this->query[$fieldName];
    }

    public function getRequestValue($fieldName)
    {
        return $this->request[$fieldName];
    }

    public function getServerValue($fieldName)
    {
        return $this->server[$fieldName];
    }

    public function get(string $fieldName) {
        return $this->method === 'GET' ? $this->query[$fieldName] : $this->request[$fieldName];
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
