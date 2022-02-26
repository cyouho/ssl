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
     * DB table name
     * 数据库表名
     */
    const TABLE_NAME = 'user_accounts';

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
        $id = DB::table(self::TABLE_NAME)->insertGetId($data);

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
     * Get user session data by unified function
     * 使用统一方法获取用户session
     * 
     * @param string $email <User email | 用户email>
     * 
     * @return object
     */
    public function getUserCookie($email)
    {
        return $this->selectUserData($columnName = ['user_session'], $condition = [['user_email', '=', $email]]);
    }

    /**
     * Update user total login times
     * 更新用户总登录次数
     * 
     * @param string $email <User email | 用户email>
     * 
     * @return void
     */
    public function updateUserTotalLoginTimes($email)
    {
        $affected = DB::update('update user_accounts set total_login_times = total_login_times + 1 where user_email = ?', [$email]);
    }

    /**
     * Update user last login time
     * 更新用户最后登录时间
     * 
     * @param string $loginTime <User login time | 用户最后登录时间>
     * @param string $email     <User email | 用户email>
     * 
     * @return void
     */
    public function updateLastLoginTime($loginTime, $email)
    {
        $affected = DB::update('update user_accounts set last_login_at = ? where user_email = ?', [$loginTime, $email]);
    }

    /**
     * Updata user session
     * 更新用户session
     * 
     * @param string $email   <User email | 用户email>
     * @param string $session <User session | 用户session>
     * 
     * @return void
     */
    public function updataUserSession($email, $session)
    {
        $this->updateUserData($condition = [['user_email', $email]], $updataData = ['user_session' => $session]);
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
        $result = DB::table(self::TABLE_NAME)
            ->select('user_password')
            ->where($key, '=', $userData[$key])
            ->get();

        $hashPassword = $result[0]->user_password;

        return Hash::check($password, $hashPassword);
    }

    public function deleteUserSession($userData, $deleteData)
    {
        $this->updateUserData($condition = [['user_email', $userData]], $deleteData);
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
        $id = DB::table(self::TABLE_NAME)
            ->select('user_id')
            ->where('user_email', '=', $data)
            ->get();

        return isset($id[0]) ? $id : '';
    }

    /**
     * Select user data real function
     * 检索用户信息真实方法
     * 
     * @param array $columnName <Select columnName | 检索的字段名>
     * @param array $condition  <Where condition | 检索的where约束条件>
     * 
     * @return object
     */
    private function selectUserData($columnName = ['*'], $condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return $result;
    }

    /**
     * Updata user data real function
     * 更新用户信息真实方法
     * 
     * @param array $condition  <Where condition | 检索的where约束条件>
     * @param array $updataData <Updata data | 需要更新的数据>
     * 
     * @return void
     */
    private function updateUserData($condition = [], $updataData = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->where($condition)
            ->update($updataData);
    }

    /**
     * Delete user data real function
     * 删除用户信息真实方法
     * 
     * @param array $condition <Where condition | 删除的where约束条件>
     * 
     * @return void
     */
    private function deleteUserData($condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->where($condition)
            ->delete();
    }
}
