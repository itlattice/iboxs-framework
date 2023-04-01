<?php
namespace until;

class ShortLink{
    /**
     * 生成短链接
     */
    public static function GetShortLink($url,$uptime=-1){
        $info=new self();
        return $info->create($url,$uptime);
    }

    const API_URL    = 'https://gz8.co/api/getshort';
    const APP_KEY    = '';

    public function create($url,$uptime)
    {
        $str=set_salt(8);
        $time=time();
        $sign=md5(md5(''.$str.urlencode($url).$time).self::APP_KEY);
        $res=self::post(self::API_URL,[
            'appid'=>'',
            'sign'=>$sign,
            'str'=>$str,
            'time'=>$time,
            'url'=>$url,
            'up'=>$uptime
        ]);
        if($res===false){
            return false;
        }
        $json=json_decode($res,true);
        if(!$json){
            return false;
        }
        $code=$json['code'];
        if($code==0){
            $url=$json['data']['url'];
            return $url;
        } else{
            return $json['msg'];
        }
    }

    private static function post($url, $post_data){
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}