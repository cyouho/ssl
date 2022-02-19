<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for User Account
 * 用户账户 用模型文件
 */
class UserAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 数据库列白名单
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Insert user data
     * 插入用户数据
     * 
     * 
     */
    public function insertUserData($data)
    {
    }
}
