<?php

namespace app\common\tools;

use lib\GoogleAuthenticator;

class GoogleAction
{
    //生成谷歌key
    public function google_key(){
        $ga = new GoogleAuthenticator();
        return $ga->createSecret();
    }

    //生成二维码链接
    public function google_qr_url($Blog,$secret){
        $ga = new GoogleAuthenticator();
        return $ga->getQRCodeGoogleUrl($Blog,$secret);
    }

    //验证验证码
    public function verification_code($secret,$oneCode){
        $ga = new GoogleAuthenticator();
        $checkResult = $ga->verifyCode($secret, $oneCode, 0);    // 2 = 2*30sec clock
        if ($checkResult) {
            return true;
        } else {
            return false;
        }
    }
}