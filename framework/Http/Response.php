<?php

namespace Soda\Http;

use Soda\Core\Base;

class Response extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $request;
    
    /**
     * @getter
     * @setter
     */
    protected $content = '';
    
    /**
     * @getter
     * @setter
     */
    protected $code = 200;
    
    /**
     * @getter
     * @setter
     */
    protected $headers = [];

    public function __construct($content = '', $code = 200, $headers = [])
    {
        $this->content = $content;
        $this->code = $code;
        $this->headers = $headers;
    }

    public function send()
    {
        http_response_code($this->code);

        $this->sendHeaders();
        $this->sendContent();
    }

    public function sendHeaders()
    {
        if (!headers_sent()) {
            foreach ($this->headers as $header => $value) {
                header($header . ': ' . $value);
            }
        }
    }

    public function sendContent()
    {
        echo $this->content;
    }
}