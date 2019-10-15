<?php

namespace Soda\Http;

class RedirectResponse extends Response
{
    /**
     * @getter
     * @setter
     */
    protected $targetUrl;

    public function __construct(string $url, int $status = 302, array $headers = [])
    {
        parent::__construct('', $status, $headers);
        $this->setTargetUrl($url);
    }

    public function setTargetUrl(string $url): self
    {
        $this->setContent(
            sprintf('<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="0;url=%1$s" />
        <title>Redirecting to %1$s</title>
    </head>
    <body>
        Redirecting to <a href="%1$s">%1$s</a>.
    </body>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8')));

        $this->headers['Location'] = $url;

        return $this;
    }
}