<?php
/**
 * 支付从这里开始
 * @author  zqu zqu1016@qq.com
 */
namespace iboxs\carbon;

use iboxs\carbon\lib\Base;
use iboxs\carbon\utils\Days;
use iboxs\carbon\utils\Hours;
use iboxs\carbon\utils\Minutes;
use iboxs\carbon\utils\Month;
use iboxs\carbon\utils\Sessions;
use iboxs\carbon\utils\Years;

/**
 * @property int|string $unix Unix时间戳
 * @property int|string $date Y-m-d日期参数
 * @property int|string $year 年份
 * @property int|string $month 月
 * @property int|string $day 日
 * @property int|string $hour 小时（24小时制）
 * @property int|string $h 小时（12小时制）
 * @property int|string $week 周几
 * @property int|string minute 分钟
 * @property int|string $session 秒
 *
 */
class Carbon extends Base
{
    use Years,Month,Days,Hours,Minutes,Sessions;
    public $time;
    public static function now(){
        $class=new self();
        $class->time=date('Y-m-d H:i:s');
        return $class;
    }

    public static function fromTime(string $time){
        $time=strtotime($time);
        if($time==false){
            throw new \Exception('时间参数格式错误');
        }
        $class=new self();
        $class->time=date('Y-m-d H:i:s',$time);
        return $class;
    }

    public static function fromUnix(int $time){
        $class=new self();
        $class->time=date('Y-m-d H:i:s',$time);
        return $class;
    }

    public function __toString()
    {
        return $this->time;
    }

    public function format($format){
        return date($format,strtotime($this->time));
    }

    public function __get($name){
        switch ($name){
            case 'date':
                return date('Y-m-d',strtotime($this->time));
            case 'year':
                return date('Y',strtotime($this->time));
            case 'month':
                return date('m',strtotime($this->time));
            case 'day':
                return date('d',strtotime($this->time));
            case 'hour':
                return date('H',strtotime($this->time));
            case 'h':
                return date('h',strtotime($this->time));
            case 'week':
                return date('w',strtotime($this->time));
            case 'minute':
                return date('i',strtotime($this->time));
            case 'session':
                return date('s',strtotime($this->time));
            case 'unix':
                return strtotime($this->time);
            default:
                return date($name,strtotime($this->time));
        }
    }
}