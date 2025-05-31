<?php

namespace app\common\types;

class QueryParams
{
    public $params = [];
    public $limit = null;
    public $field = "*";
    public $page = 0;
    public $order = "";
    private $maxLimit = 1000;
    public function __construct(array $params)
    {
        if (isset($params["page"])) {
            $this->page = $params["page"];
            unset($this->params["page"]);
        }
        if (isset($params["limit"])) {
            $this->setLimit($params["limit"]);
            unset($params["limit"]);
        }
        if (!isset($params['is_del'])) {
            $params['is_del'] = 0;
        }
        $this->params = $params;
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
