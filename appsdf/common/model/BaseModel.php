<?php

namespace app\common\model;

use app\common\tools\Str;
use think\Model;

class BaseModel extends Model
{
    protected $hidden = ['is_del'];
    protected $readonly = ['created_at'];
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    public function searchIsDelAttr($query, $value, $data)
    {
        if ($value !== null) $query->where("is_del", (int)$value);
    }
    public function searchStatusAttr($query, $value)
    {
        $ext = '=';
        if (is_array($value) || (is_string($value) && strpos($value, ',') !== false)) $ext = 'in';
        if ($value !== null)  $query->where('status', $ext, $value);
    }
    public function searchIdAttr($query, $value)
    {
        $ext = '=';
        if (is_array($value) || (is_string($value) && strpos($value, ',') !== false)) $ext = 'in';
        if ($value !== null)  $query->where('id', $ext, $value);
    }
    public function withSearch($fields, $data = [])
    {

        foreach ($fields as $key => $field) {
            // 检测搜索器
            $fieldName = is_numeric($key) ? $field : $key;
            $method    = 'search' . Str::studly($fieldName) . 'Attr';
            if (method_exists($this, $method)) {
                $this->$method($this, $data[$field] ?? null, $data);
            }
        }

        return $this;
    }
}
