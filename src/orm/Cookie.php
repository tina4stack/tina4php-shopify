<?php

class Cookie extends \Tina4\ORM
{
    public $tableName="cookie";
    public $primaryKey = "name,shop";

    public $name;
    public $value;
    public $expires;
    public $shop;

}