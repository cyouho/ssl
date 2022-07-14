<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserLoginRecord extends Model
{
    use HasFactory;

    /**
     * Table Name For DB.
     * 数据库表名
     */
    const TABLE_NAME = 'user_login_records';

    /**
     * Set User Login Record.
     * 设置用户登录记录
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition  <DB where condition | 数据库where条件>
     */
    public function setUserLoginRecord(array $columnName = [], array $condition = [])
    {
        $this->createUserData($columnName, $condition);
    }

    /**
     * Get User Login Record.
     * 获取用户登录记录信息
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB where condition | 数据库 where 检索条件>
     * @param string $orderByColumnName <order by column name | 排序字段名>
     * @param string $orderBy <order by default value: desc | 默认排序: desc>
     * 
     * @return mix function
     */
    public function getUserLoginRecord(
        array $columnName = [],
        array $condition = [],
        string $orderByColumnName = '',
        string $orderBy = 'desc'
    ) {
        return $this->selectUserData($columnName, $condition, $orderByColumnName, $orderBy);
    }

    private function createUserData(array $columnName = [], array $condition = [])
    {
        $affected = DB::table(self::TABLE_NAME)
            ->updateOrInsert(
                $columnName,
                $condition
            );
    }

    private function selectUserData(
        array $columnName = ['*'],
        array $condition = [],
        string $orderByColumnName,
        string $orderBy
    ) {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->orderBy($orderByColumnName, $orderBy)
            ->get();

        return $result;
    }
}
