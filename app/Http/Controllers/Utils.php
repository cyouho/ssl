<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Utils extends Controller
{
    /**
     * Make md5 value for session
     * 使用 md5 来生成所需的 session
     * 
     * @param void
     * 
     * @return string <md5 of now timestamp | 现在时间戳的md5值>
     */
    public static function getSessionRandomMD5()
    {
        return md5(time());
    }

    /**
     * Get name from email
     * 从 email 中获取 name
     * 
     * @param string $email <User email | 用户email>
     * 
     * @return string <User name from email | 从用户email里提取的用户名>
     */
    public static function getNameFromEmail($email)
    {
        return substr($email, 0, strripos($email, "@"));
    }
}
