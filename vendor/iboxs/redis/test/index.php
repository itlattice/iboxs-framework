<?php
require_once '../vendor/autoload.php';
use iboxs\redis\Client;

$client=new Client();
$client->basic()->get('s');