<?php
namespace until;

use iboxs\basic\Basic;
use Qcloud\Sms\SmsSingleSender;
use iboxs\redis\Redis;

class Sms{

    public static function sendSms($telephone,$templateId,$params=[]){
        if(!Basic::isPhone($telephone)){
            return false;
        }
        $appid = config("sms.appid");
        $appkey = config("sms.appkey");
        $phoneNumber = $telephone;
        $smsSign = config("sms.smsSign");
        $rsp=array();
        try {
             if(env("app_debug",false)==true){
                 file_put_contents(runtime_path()."smscode.txt",json_encode($params,JSON_UNESCAPED_UNICODE));
                 return true;
             }
            $ssender = new SmsSingleSender($appid, $appkey);
            $result = $ssender->sendWithParam("86", $phoneNumber, $templateId,$params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result,true);
            if($rsp['result']==0){
                return true;
            }
            return false;
        } catch(\Exception $e) {
            return false;
        }
    }
}