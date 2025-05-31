<?php

namespace app\common\types;

class QueryParams
{
    public $params = [];
    public $limit = 0;
    public $field = "*";
    public $page = 0;
    public $order = "";
    private $maxLimit = 1000;
    public function __construct(array $params)
    {
        $this->params = $params;
        if (isset($this->params["page"])) {
            $this->page = $this->params["page"];
            unset($this->params["page"]);
        }
        if (isset($this->params["limit"])) {
            $this->setLimit($this->params["limit"]);
            unset($this->params["limit"]);
        }
    }
    public function getParams()
    {
        return $this->params;
    }
    public function setParams($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    public function setLimit(int $limit)
    {
        if ($limit > $this->maxLimit) $limit = $this->maxLimit;
        $this->limit = $limit;
        return $this;
    }
    public function getLimit()
    {

        return $this->limit;
    }
    public function setField($field)
    {
        $this->field = $field;
    }
    public function getField()
    {
        return $this->field;
    }
    public function setPage(int $page)
    {
        $this->page = $page;
        return $this;
    }
    public function getPage()
    {
        return $this->page;
    }
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
    public function getOrder()
    {
        return $this->order;
    }
}
