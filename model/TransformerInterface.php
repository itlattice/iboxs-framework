<?php
namespace model;

use iboxs\Model;

interface TransformerInterface{
    public function transformer(Model $data);
}
?>