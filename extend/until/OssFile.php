<?php
namespace until;
use iboxs\basic\Basic;

class OssFile{

    protected static $config=[];

    private static function init($region='PUBLIC'){
        self::$config=array(
            'region'      => config('oss.'.$region.'.region'),
            'credentials' => array(
                'appId'     => config('oss.'.$region.'.appId'),
                'secretId'  => config('oss.'.$region.'.SecretId'),
                'secretKey' => config('oss.'.$region.'.SecretKey')
            )
        );
    }

   public static function qcloudCosUpload($info = array(),$region='PUBLIC')
    {
        self::init();
        //引用COS sdk
        $cosBasic = new \Qcloud\Cos\Client(
            self::$config
        );
        $file = $info['pathname'];
        try {
            $data = array( 'Bucket' => config('oss.'.$region.'.bucket'), 'Key'  => $info['saveName'], 'Body' => fopen($file, 'rb') );
            //判断文件大小 大于5M就分块上传
            $result = $cosBasic->Upload( $data['Bucket'] , $data['Key'] , $data['Body']);
            if( $result ){
                return $result;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

   public static function GetDownUrl($key,$region='PUBLIC',$minute=10){
    // dd($region);
    // dd(config('oss.'.$region.'.SecretKey'));
        $cosBasic = new \Qcloud\Cos\Client(
            array(
                'region'      => config('oss.'.$region.'.region'),
                'credentials' => array(
                    'appId'     => config('oss.'.$region.'.appId'),
                    'secretId'  => config('oss.'.$region.'.SecretId'),
                    'secretKey' => config('oss.'.$region.'.SecretKey')
                )
            )
        );
        $url = "/{$key}";
        $signedUrl = $cosBasic->getObjectUrl(config('oss.'.$region.'.bucket'), $key, '+'.$minute.' minutes');
        $signedUrl=str_replace("http://","https://",$signedUrl);
        $signedUrl=self::handleUrl($signedUrl,$region);
        return $signedUrl;
    }

    private static function handleUrl($url,$region='PUBLIC'){
        $keyconfig=config('oss.'.$region.'.url');
        $old="https://".config('oss.'.$region.'.bucket').".cos.".config('oss.'.$region.'.region').".myqcloud.com";
        $url=str_replace($old,"https://".$keyconfig,$url);
        return $url;
    }

    public static function DelOssFile($key,$region='PUBLIC'){
        $cosBasic = new \Qcloud\Cos\Client(
            array(
                'region'      => config('oss.'.$region.'.region'),
                'credentials' => array(
                    'appId'     => config('oss.'.$region.'.appId'),
                    'secretId'  => config('oss.'.$region.'.SecretId'),
                    'secretKey' => config('oss.'.$region.'.SecretKey')
                )
            )
        );
        // $url = "/{$key}";
        $signedUrl = $cosBasic->deleteObject(
            array(
                'Bucket' => config('oss.'.$region.'.bucket'),
                'Key' => $key
            )
        );
        return $signedUrl;
    }
}
?>