<?php
/**
 * Tina4 - This is not a 4ramework.
 * Copy-right 2007 - current Tina4
 * License: MIT https://opensource.org/licenses/MIT
 */

class Session extends \Tina4\ORM
{
    public $tableName="session";
    public $primaryKey = "shop";
    public $shop;
    public $sessionId;
    public $sessionData;
}
