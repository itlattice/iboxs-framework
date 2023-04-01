<?php
namespace until;
class Entry{
    
    protected $key='';

    protected $iv='';

    public function __construct($int=0)
    {
        $int=$int % 8;
        $pwdArr=[
            [
                'pwd'=>'04yxysgyain*6458.12s6M45x6ma58dx8&^dsak134166',
                'iv'=>chr(0xF8) . chr(0xB6) . chr(0xA1) . chr(0x0F) . chr(0xA9) . chr(0x40) . chr(0x6B) . chr(0x1A) . chr(0x0) . chr(0x0) . chr(0x78) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0xA5) . chr(0x13)
            ]
        ];
        $this->key=$pwdArr[$int]['pwd'];
        $this->iv=$pwdArr[$int]['iv'];
    }

    public static function Aes($str,$int=0){
        $lei=new Entry($int);
        return $lei->AesRun($str);
    }

    public static function Des($str,$int=0){
        $lei=new Entry($int);
        return $lei->DesRun($str);
    }

    public function DesRun($str){
        $password = $this->key;
        $method = 'aes-256-cbc';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $iv = $this->iv;
        $decrypted = openssl_decrypt(base64_decode($str), $method, $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }

    public function AesRun($str){
        $password =  $this->key;
        $method = 'aes-256-cbc';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $iv = $this->iv;
        $encrypted = base64_encode(openssl_encrypt($str, $method, $key, OPENSSL_RAW_DATA, $iv));
        return $encrypted;
    }
}