<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * User Servers Class.
 * 用户服务类
 */
class UserServers extends Model
{
    use HasFactory;

    /**
     * DB Table Name.
     * 数据库表名
     */
    const TABLE_NAME = 'user_servers';

    /**
     * Get User Servers.
     * 获取用户服务
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition  <DB condition | 数据库 where 检索约束条件>
     * 
     * @return mix function
     */
    public function getUserServers(array $columnName, array $codition): array
    {
        return $this->selectUserData($columnName, $codition);
    }

    /**
     * Set User Servers.
     * 设置用户服务
     * 
     * @param array $insertData <insert data with user servers | 需插入的用户服务数据>
     * 
     * @return mix function
     */
    public function setUserServers(array $insertData = [])
    {
        return $this->createUserData($insertData);
    }

    /**
     * Judge If Exist Server for User.
     * 判断用户是否已经存在服务
     * 
     * @param array $columnName <DB column name | 数据库字段名>
     * @param array $condition  <DB where condition | 数据库 where 检索约束条件>
     * 
     * @return boolean
     */
    public function ifExistServerForTheUser(array $columnName = ['*'], array $condition = []): bool
    {
        $result = $this->selectUserData($columnName, $condition);

        return isset($result[0]);
    }

    /**
     * Set User Servers Status.
     * 设置用户服务状态
     * 
     * @param array $condition <DB where condition | 数据库 where 检索约束条件>
     * @param array $updateData <Update for DB | 数据库更新数据>
     * 
     * @return mix function
     */
    public function setUserServersStatus(
        array $condition = [],
        array $updateData = []
    ) {
        return $this->updateUserData($condition, $updateData);
    }

    /**
     * Select User Data.
     * 检索用户信息方法
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition  <DB where condition | 数据库 where 检索约束条件>
     * 
     * @return array $result <select resutl | 检索结果>
     */
    private function selectUserData(array $columnName = ['*'], array $condition = []): array
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get()
            ->toArray();

        return $result;
    }

    private function createUserData(array $insertData = [])
    {
        $id = DB::table(self::TABLE_NAME)
            ->insertGetId($insertData);

        return $id;
    }

    /**
     * Update user data real function.
     * 
     * @param array $condition <query condition>
     * @param array $updateData <query updateData>
     * 
     * @return int $affected <updated status value .e.g 0 | 1>
     */
    private function updateUserData(
        array $condition = [],
        array $updateData = []
    ) {
        $affected = DB::table(self::TABLE_NAME)
            ->where($condition)
            ->update($updateData);

        return $affected;
    }
}
