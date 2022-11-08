<?php

namespace Alsharie\JawaliPayment\Helpers;


class JawaliAuthHelper
{


    private static $auth_session_name = 'LOGIN_ACCESS_TOKEN';
    private static $wallet_session_name = 'WALLET_ACCESS_TOKEN';

    public static function setAuthToken($token)
    {
        $_SESSION[self::$auth_session_name] = $token;
    }

    public static function getAuthToken()
    {
        if (isset($_SESSION[self::$auth_session_name]))
            return $_SESSION[self::$auth_session_name];
        return null;
    }

    public static function setWalletToken($token)
    {
        $_SESSION[self::$wallet_session_name] = $token;
    }

    public static function getWalletToken()
    {
        if (isset($_SESSION[self::$wallet_session_name]))
            return $_SESSION[self::$wallet_session_name];
        return null;
    }

}