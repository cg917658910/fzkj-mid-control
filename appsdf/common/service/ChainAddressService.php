<?php

namespace app\common\service;

use app\common\dao\ChainAddressDao;

class ChainAddressService extends BaseService
{
    protected $dao;
    protected $exceptFieldWhenCreate = [];
    protected $exceptFieldWhenUpdate = [];
    protected $exceptFieldWhenSave = ['is_del', 'id'];

    public function __construct()
    {
        $this->dao = new ChainAddressDao();
    }

    protected function handleCreate(array &$data)
    {
        $this->handleSave($data);
    }
    protected function handleCreateAfter(array &$result) {}
    protected function handleUpdate(array &$data)
    {
        $this->handleSave($data);
    }
    protected function handleSave(array &$data)
    {
        foreach ($this->exceptFieldWhenSave as $field) {
            if (isset($data[$field])) unset($data[$field]);
        }
    }
    protected function handleUpdateAfter(array &$result) {}
    protected function handleList(&$listData)
    {
        foreach ($listData as &$v) {
            self::handleDetail($v);
        }
    }
    protected function handleDetail(&$data)
    {
        if ($data) {
            if (is_object($data)) {
                $data = $data->toArray();
            }
        }
    }
    protected function handlePage(&$listData)
    {
        foreach ($listData['data'] as &$v) {
            self::handleDetail($v);
        }
    }
}
