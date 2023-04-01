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
                'pwd'=>'0Tyxysgyain*6458.12s6545x6ma58dx8&^dsak134166',
                'iv'=>chr(0x18) . chr(0xB6) . chr(0xA1) . chr(0x0F) . chr(0xA9) . chr(0x40) . chr(0x6B) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x78) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0xA5) . chr(0x13)
            ],
            [
                'pwd'=>'K0rC*ut3.Uz3nXS.WxXEe0zMIxglOG5xwssTJWnY8B0Py',
                'iv'=>chr(0x19) . chr(0xEA) . chr(0xA1) . chr(0x0F) . chr(0xA8) . chr(0x50) . chr(0x6F) . chr(0xBA) . chr(0xC6) . chr(0x0) . chr(0x45) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x07) . chr(0x13)
            ],
            [
                'pwd'=>'ZFeGD^y0Vpfmg6qG*vQR0EJD5coXsBcG.QwgwtyKea0tR',
                'iv'=>chr(0x20) . chr(0xD6) . chr(0xA1) . chr(0x0F) . chr(0xA7) . chr(0xAC) . chr(0x6C) . chr(0x06) . chr(0x0) . chr(0x0) . chr(0x75) . chr(0x0) . chr(0x0) . chr(0x11) . chr(0xDF) . chr(0x13)
            ],
            [
                'pwd'=>'Sp1JdkNbeAbN.lRRI^5L2LY86WlKaD1.P1TyIsiySrR*a',
                'iv'=>chr(0x18) . chr(0xB9) . chr(0xA1) . chr(0x0F) . chr(0xA6) . chr(0xB4) . chr(0x64) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x14) . chr(0x0) . chr(0x0) . chr(0x10) . chr(0x06) . chr(0x13)
            ],
            [
                'pwd'=>'Sp1JdkNbeAbN.lRRI^5L2LY86WlKaD1.P1TyIsiySrR*a',
                'iv'=>chr(0x18) . chr(0xB9) . chr(0xA1) . chr(0x0F) . chr(0xA6) . chr(0xB4) . chr(0x64) . chr(0x0) . chr(0x0) . chr(0xB7) . chr(0x14) . chr(0x0) . chr(0x0) . chr(0x10) . chr(0x06) . chr(0x13)
            ],
            [
                'pwd'=>'Sp1J.kNbeAbN.lRRI^5L2LM86WlKaD1.P1TyIsiySrR*a',
                'iv'=>chr(0x18) . chr(0xB9) . chr(0xA1) . chr(0x0F) . chr(0xA6) . chr(0xB5) . chr(0x64) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x1B) . chr(0x0) . chr(0x0) . chr(0x10) . chr(0x06) . chr(0x13)
            ],
            [
                'pwd'=>'Sp1Jd*NbeAbN.lRRI^5L2Ls86WlKaD1.P1TyIsiySrR*a',
                'iv'=>chr(0x18) . chr(0xB9) . chr(0xA1) . chr(0x0F) . chr(0xA6) . chr(0xB6) . chr(0x64) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x1A) . chr(0x0) . chr(0x0) . chr(0x10) . chr(0x06) . chr(0x13)
            ],
            [
                'pwd'=>'Sp1JdkNbCAbN.lRRI^5L28Y86WlKaD1.P1TyIsiySrR*a',
                'iv'=>chr(0x18) . chr(0xB9) . chr(0xA1) . chr(0x0F) . chr(0xA6) . chr(0xB7) . chr(0x64) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0xC4) . chr(0x0) . chr(0x0) . chr(0x10) . chr(0x06) . chr(0x13)
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