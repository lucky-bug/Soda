<?php

namespace Soda\Pagination;

use Soda\Core\Base;

class Pagination extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $page = 1;

    /**
     * @getter
     * @setter
     */
    protected $pageLimit = 3;

    /**
     * @getter
     * @setter
     */
    protected $data = [];

    public function getCurrentPage() {
        return array_splice($this->data, ($this->page - 1) * $this->pageLimit, $this->pageLimit);
    }
}
