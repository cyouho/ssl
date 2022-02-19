<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Utils extends Controller
{
    /**
     * Make md5 value for session
     * 使用 md5 来生成所需的 session
     */
    public static function getSessionRandomMD5()
    {
        return md5(time());
    }

    /**
     * Get name from email
     * 从 email 中获取 name
     */
    public static function getNameFromEmail($email)
    {
        return substr($email, 0, strripos($email, "@"));
    }
}
