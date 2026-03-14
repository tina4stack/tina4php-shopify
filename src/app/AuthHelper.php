<?php
/**
 * Tina4 - This is not a 4ramework.
 * Copy-right 2007 - current Tina4
 * License: MIT https://opensource.org/licenses/MIT
 */

class AuthHelper extends \Tina4\Auth
{
    /**
     * Function validate the token
     * @param string $token
     * @param string $publicKey
     * @param string $encryption
     * @return bool
     */
    function validToken(string $token, string $publicKey = "", string $encryption = \Nowakowskir\JWT\JWT::ALGORITHM_RS256): bool
    {
        //we will rely on shopify to validate the token
        return true;
    }
}
