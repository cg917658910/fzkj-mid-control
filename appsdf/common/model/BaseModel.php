<?php

namespace app\common\model;

use app\common\tools\Str;
use think\Model;

class BaseModel extends Model
{
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
