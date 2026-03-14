<?php
/**
 * Tina4 - This is not a 4ramework.
 * Copy-right 2007 - current Tina4
 * License: MIT https://opensource.org/licenses/MIT
 */

class Cookie extends \Tina4\ORM
{
    public $tableName="cookie";
    public $primaryKey = "name,shop";

    public $name;
    public $value;
    public $expires;
    public $shop;

}
