<?php

namespace Soda\Pagination;

use Soda\Core\Base;

class Pagination extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $page;

    /**
     * @getter
     * @setter
     */
    protected $totalPages;

    /**
     * @getter
     * @setter
     */
    protected $pageLimit;

    /**
     * @getter
     * @setter
     */
    protected $data;

    public function __construct($options = [])
    {
        $this->page = 1;
        $this->pageLimit = 3;
        $this->data = [];
        parent::__construct($options);
        $this->totalPages = (int)((count($this->data) + $this->pageLimit -1) / $this->pageLimit);
    }

    public function getCurrentPage()
    {
        return array_splice($this->data, ($this->page - 1) * $this->pageLimit, $this->pageLimit);
    }

    public function hasNext()
    {
        return $this->page < $this->totalPages;
    }

    public function hasPrev()
    {
        return $this->page > 1;
    }
}
