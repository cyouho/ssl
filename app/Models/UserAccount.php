<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Get user id
     * 获取用户id
     * 
     * @param int $data <User data | 用户数据>
     * 
     * @return mix
     */
    public function getUserId($data)
    {
        return $this->selectUserId($data);
    }

    /**
     * Check user password
     * 检查用户密码
     * 
     * @param array $userData <User data | 用户数据>
     * @param string $password <User password | 用户密码>
     * 
     * @return bool
     */
    public function checkUserPassword($userData, $password)
    {
        $key = key($userData);
        $result = DB::table('user_accounts')
            ->select('user_password')
            ->where($key, '=', $userData[$key])
            ->get();

        $hashPassword = $result[0]->user_password;

        return Hash::check($password, $hashPassword);
    }

    /**
     * Select user id
     * 检索用户id真实方法
     * 
     * @param array $data <User data | 用户数据>
     * 
     * @return mix $id | ''
     */
    private function selectUserId($data)
    {
        $id = DB::table('user_accounts')
            ->select('user_id')
            ->where('user_email', '=', $data)
            ->get();

        return isset($id[0]) ? $id : '';
    }
}
