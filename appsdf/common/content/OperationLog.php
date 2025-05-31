<?php

namespace app\common\content;

use app\common\model\log\OperationLogModel;
use app\common\tools\System;

class OperationLog
{
    const UPDATE_PASS = 1;//修改登录密码
    const ADD_ADMIN = 2;//添加管理员
    const UPDATE_ADMIN = 15;//编辑管理员
    const DEL_ADMIN = 16;//删除管理员
    const DEL_NUMBER = 3;//删除账号
    const DEL_IPHONE = 4;//删除设备
    const DEL_BANK_TYPE = 5;//删除银行类型
    const DEL_PAYMENT_DICT = 6;//删除代付字典
    const OPEN_WALLET = 7;//开通数字钱包
    const VIEW_WALLET_PASS = 8;//查看数字钱包密码
    const UPDATE_WALLET_PARAM = 9;//更新钱包参数
    const DEL_POOL_PLAN = 10;//删除归集计划
    const ADD_RISK_LOG = 11;//增加风控数据
    const UP_RISK_LOG = 12;//解除或扣除风控冻结
    const IN_RECHARGE_AND_CARRY = 13;//内部充提
    const UP_IN_RECHARGE_AND_CARRY = 14;//操作内部充提
    const DEL_THREE_PAYMENT_DICT = 17;//删除三方代付字典
    const IPHONE_SECRET = 18;//重置设备密钥
    const CARRY_EXAMINE = 19;//代付审核
    const CARRY_STRAIGHT = 20;//代付冲正
    const OPERATE_WALLET_ORDER = 21;//操作汇兑订单
    const WALLET_EXAMINE = 22;//兑出审核
    const OPERATE_RECHARGE_ORDER = 23;//成功充值订单
    const SAVE_NUMBER_DEL = 24;//卡号状态
    const SAVE_MEMBER_RATE = 25;//修改商户费率
    const SAVE_MEMBER_PASSWORD = 26;//修改商户密码
    const SAVE_POOL = 27;//修改归集

    /**
     * @param $data
     */
    public static function add_log($data){
         $logData = [
            'create_time' => time(),
            'login_ie' => System::get_broswer(),
            'login_os' => System::get_os(),
            'login_ip' => request()->ip(),
            'pkusa' => $data['pkusa'],
         ];
         switch ( $data['action'] ){
             case self::UPDATE_PASS://修改登录密码
                 $describe = sprintf('%s修改了登录密码',$data['user_name']);
                 break;
             case self::ADD_ADMIN://添加管理员
                 $describe = sprintf('%s添加管理员%s',$data['user_name'],$data['object']);
                 break;
             case self::UPDATE_ADMIN://编辑管理员
                 $describe = sprintf('%s编辑管理员%s',$data['user_name'],$data['object']);
                 break;
             case self::DEL_ADMIN://删除管理员
                 $describe = sprintf('%s删除管理员%s',$data['user_name'],$data['object']);
                 break;
             case self::DEL_NUMBER://删除账号
                 $describe = sprintf('%s删除账号，信息为%s',$data['user_name'],$data['object']);
                 break;
             case self::DEL_IPHONE://删除设备
                 $describe = sprintf('%s删除设备，信息为 %s',$data['user_name'],$data['object']);
                 break;
             case self::DEL_BANK_TYPE://删除银行类型
                 $describe = sprintf('%s删除银行类型，信息为 %s',$data['user_name'],$data['object']);
                 break;
             case self::DEL_PAYMENT_DICT://删除代付字典
                 $describe = sprintf('%s删除代付字典，信息为 %s',$data['user_name'],$data['object']);
                 break;
             case self::OPEN_WALLET://开通数字钱包
                 $describe = sprintf('%s开通了数字钱包',$data['user_name']);
                 break;
             case self::VIEW_WALLET_PASS://开通数字钱包
                 $describe = sprintf('%s查看了数字钱包登录密码',$data['user_name']);
                 break;
             case self::UPDATE_WALLET_PARAM://更新钱包参数
                 $describe = sprintf('%s更新了数字钱包的参数，信息为 %s',$data['user_name'],$data['object']);
                 break;
             case self::DEL_POOL_PLAN://删除归集计划
                 $describe = sprintf('%s删除归集计划，信息为 %s',$data['user_name'],$data['object']);
                 break;
             case self::ADD_RISK_LOG://删除归集计划
                 $describe = sprintf('%s添加了风控管理，信息为 %s',$data['user_name'],$data['object']);
                 break;
             case self::UP_RISK_LOG://解除或扣除风控冻结
             case self::IN_RECHARGE_AND_CARRY://内部充提
             case self::UP_IN_RECHARGE_AND_CARRY://处理内部充提
             case self::CARRY_EXAMINE://代付审核
             case self::CARRY_STRAIGHT://代付冲正
             case self::OPERATE_WALLET_ORDER://操作汇兑订单
             case self::WALLET_EXAMINE://兑出审核
             case self::OPERATE_RECHARGE_ORDER://成功充值订单
             case self::SAVE_NUMBER_DEL://卡号状态
             case self::SAVE_MEMBER_RATE://修改商户费率
             case self::SAVE_MEMBER_PASSWORD://修改商户密码
             case self::SAVE_POOL://修改归集计划
                 $describe = sprintf('%s%s',$data['user_name'],$data['object']);
                 break;
             case self::DEL_THREE_PAYMENT_DICT://删除三方代付字典
                 $describe = sprintf('%s删除三方代付字典，信息为 %s',$data['user_name'],$data['object']);
                 break;
             case self::IPHONE_SECRET://重置设备密钥
                 $describe = sprintf('%s重置了设备的密钥，信息为 %s',$data['user_name'],$data['object']);
                 break;
         }
        (new OperationLogModel())->insert(array_merge($logData,[
            'describe' => $describe,
        ]));
    }
}