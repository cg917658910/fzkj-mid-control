<?php

namespace app\common\service;

use app\common\dao\system\SystemAdminDao;
use app\common\enum\CodeEnum;
use app\common\exception\ApiException;
use app\common\tools\GoogleAction;
use app\common\tools\StringBuilder;
use app\common\tools\System;
use think\Cache;

class LoginService extends BaseService
{
    protected $dao;
    protected  $tempUserTokenPrefix = "member_";
    protected  $tokenExpire = 60 * 60 * 8; // 8小时
    protected  $tempGoogleKeyExpire = 60 * 10; // 10 minutes
    public function __construct()
    {
        $this->dao = new SystemAdminDao();
    }
    public function login($account, $password): array
    {
        // 1.verify account&password
        $admin = $this->verifyLoginUser($account, $password);
        // 检测登录ip
        if (!empty($admin['allow_ip'])) {
            (array)$allow_ip = explode(',', $admin['allow_ip']);
            (string)$ip = request()->ip();
            if (!in_array($ip, $allow_ip)) {
                throw new ApiException(CodeEnum::FORBIDDEN, "{$ip} 不在IP白名单内");
            }
        }
        // 2.verify google code
        $result = [
            "is_two" => true,
            'uid' => $this->createTempUserToken($admin['pkusa'])
        ];
        if (!$admin["googlekey"]) {
            $result['two_verify_url'] = $this->createGoogleVerifyUrl($admin['pkusa']);
        }
        return $result;
    }
    /**
     * Summary of verifyGoogleCode
     * @param string $uid 临时uid
     * @param mixed $code
     * @return void
     */
    public function verifyGoogleCode(string $uidStr, $code): array
    {
        (int)$uid = (new StringBuilder())->decode($uidStr);
        if (!$uid) {
            throw new ApiException(CodeEnum::INVALID_PARAMS, 'invalid uid');
        }
        $admin = $this->dao->findByID($uid);
        if (!$admin) {
            throw new ApiException(CodeEnum::NOT_FOUND, 'not found admin');
        }
        $admin = $admin->toArray();
        $googlekey = $admin['googlekey'];
        // 判断是否需要绑定google key
        if (!$googlekey) {
            $googlekey = $this->getTempGoogleKey($uid);
        }
        $res = (new GoogleAction())->verification_code($googlekey, $code);
        if (!$res) {
            throw new ApiException(CodeEnum::FORBIDDEN, 'googlekey verify failed');
        }
        // 更新user googkey
        if (!$admin['googlekey'] && !$this->updateUserGoogleKey($uid, $googlekey)) {
            throw new ApiException(CodeEnum::SERVER_ERROR, 'update google failed');
        }
        return ["token" => $this->createUserToken($admin)];
    }
    public function updateUserGoogleKey(int $uid, string $googleKey)
    {
        return $this->dao->updateGoogleKey($uid, $googleKey);
    }
    protected function createUserToken(array $admin): string
    {
        $uid = $admin["pkusa"];
        $ipStr = request()->ip();
        $token = md5(System::get_broswer() . System::get_os() . $ipStr . time() . '_admin') . $uid;
        Cache::set($token, json_encode($admin, JSON_UNESCAPED_UNICODE), $this->tokenExpire);
        return $token;
    }

    protected function createTempGoogleKey(int $uid): string
    {
        $GoogleAction = new GoogleAction();
        $google_key = $GoogleAction->google_key();
        Cache::set($this->getTempGoogleKeyCacheNameByUid($uid), $google_key, $this->tempGoogleKeyExpire);
        return $google_key;
    }
    protected function getTempGoogleKey(int $uid): string
    {
        return Cache::get($this->getTempGoogleKeyCacheNameByUid($uid));
    }
    protected function getTempGoogleKeyCacheNameByUid(int $uid): string
    {
        return  "googlekey_tmp_" . $uid;
    }
    protected function createGoogleVerifyUrl(int $uid): string
    {
        $googleKey = $this->createTempGoogleKey($uid);
        return (new GoogleAction())->google_qr_url($uid, $googleKey);
    }
    protected function createTempUserToken(int $uid): string
    {
        return (new StringBuilder())->aes_encode($this->tempUserTokenPrefix . $uid);
    }
    protected function verifyLoginUser($account, $password)
    {
        $admin = $this->dao->findByUserName($account);
        if (!$admin) {
            throw new ApiException(CodeEnum::NOT_FOUND);
        }
        if ($this->hashPwd($password) != $admin['admin_pass']) {
            throw new ApiException(CodeEnum::NOT_FOUND);
        }
        return $admin;
    }

    private function hashPwd($password)
    {
        return md5(md5($password));
    }
}
