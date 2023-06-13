<?php

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