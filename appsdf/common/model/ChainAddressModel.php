<?php

namespace app\common\model;

use app\common\model\BaseModel;

class ChainAddressModel extends BaseModel
{
    protected $name = 'zt_chain_address';

    public function searchNetworkIdAttr($query, $value)
    {
        $ext = '=';
        if (is_array($value) || (is_string($value) && strpos($value, ',') !== false)) $ext = 'in';
        if ($value !== null)  $query->where('network_id', $ext, $value);
    }
    public function searchKeywordsAttr($query, $value, $data)
    {
        $value && $query->where('address', 'like', '%' . $value . '%');
    }
}
