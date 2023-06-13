<?php

class Session extends \Tina4\ORM
{
    public $tableName="session";
    public $primaryKey = "shop";
    public $shop;
    public $sessionId;
    public $sessionData;
}