<?php

namespace app\common\traits;

use app\common\dao\system\SystemConfigDao;
use app\common\enum\CodeEnum;
use app\common\exception\ApiException;
use think\Cache;
use think\exception\ValidateException;

trait ApiBaseTraits
{
    protected function validateRequest($scene = null)
    {
        $controller = request()->controller();
        $validatorClass = "app\\admin\\validate\\{$controller}Validate";
        if (!class_exists($validatorClass)) return;
        if (!$scene) $scene = request()->action();
        $validator = new $validatorClass();
        if (!$validator->scene($scene)->check(request()->param())) {
            throw new ValidateException($validator->getError());
        }
    }
    protected function validateRequestMask()
    {
        $mask = request()->param("qz");
        if (!$mask) {
            throw new ApiException(CodeEnum::FORBIDDEN_INVALID_MASK, "qzm nil");
        }
        // 查询 LOGIN_SUFFIX
        $apiSafeMask = (new SystemConfigDao())->getByConfigKey("LOGIN_SUFFIX");
        if ($apiSafeMask && $mask !== $apiSafeMask) {
            throw new ApiException(CodeEnum::FORBIDDEN_INVALID_MASK);
        }
    }
    protected function requestAuth()
    {
        $token = request()->header("authorization");
        if (!$token) {
            throw new ApiException(CodeEnum::UNAUTHORIZED, "token 不能为空");
        }
        $admin = Cache::get($token);
        if (!$admin) {
            throw new ApiException(CodeEnum::UNAUTHORIZED, "token 无效");
        }
        $admin = json_decode($admin, true);
        if (!isset($admin["pkusa"]) || $admin['pkusa'] <= 0) {
            throw new ApiException(CodeEnum::UNAUTHORIZED, "token 解析失败");
        }
        if (property_exists($this, 'admin_login')) {
            $this->admin_login = $admin;
        }
    }
}
