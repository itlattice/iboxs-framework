<?php
namespace iboxs\test;
require __DIR__."/../vendor/autoload.php";
use iboxs\carbon\Carbon;
$result=Carbon::now()->AddYears(5)->AddMonths()->AddDays()->AddHours()->AddMinuts()->AddSession()->unix;
echo $result;
?>