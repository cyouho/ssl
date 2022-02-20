<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
     * @param array $data <User data | 用户数据>
     * 
     * @return int $id <Inserted user id | 插入的用户id>
     */
    public function insertUserData($data)
    {
        $id = DB::table('user_accounts')->insertGetId($data);

        return $id;
    }
}
