<?php
namespace app\common;

use iboxs\Model;

class BaseModel extends Model
{
    protected $autoWriteTimestamp=true;
    protected $updateTime=false;
    protected $createTime='add_time';
}