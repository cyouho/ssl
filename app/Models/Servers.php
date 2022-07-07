<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Servers Class.
 * 服务类
 */
class Servers extends Model
{
    use HasFactory;

    /**
     * DB Table Name.
     * 数据库表名
     */
    const TABLE_NAME = 'servers';

    /**
     * Get All Servers.
     * 获取所有服务
     * 
     * @param array $columnName <column name | 查询字段名>
     * @param array $condition  <where condition | 查询条件>
     * 
     * @return mix function <function | 方法>
     */
    public function getAllServers(array $columnName = ['*'], array $condition = [])
    {
        return $this->selectServersData($columnName, $condition);
    }

    /**
     * Select Servers Data.
     * 检索服务数据
     * 
     * @param array $columnName <column name | 查询字段名>
     * @param array $condition  <where condition | 查询条件>
     * 
     * @return object $result <servers datas | 服务数据>
     */
    private function selectServersData(array $columnName = ['*'], array $condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return $result;
    }

    /**
     * Insert Servers Datas.
     * 插入服务数据
     * 
     * @param array $insertData <insert data | 需插入的数据>
     * 
     * @return int $id <insert id by column | 插入数据后的列号>
     */
    private function insertServerData(array $insertData = [])
    {
        $id = DB::table(self::TABLE_NAME)
            ->insertGetId($insertData);

        return $id;
    }
}
