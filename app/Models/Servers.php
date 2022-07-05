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

    private function selectServersData(array $columnName = ['*'], array $condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return $result;
    }

    private function insertServerData(array $insertData = [])
    {
        $id = DB::table(self::TABLE_NAME)
            ->insertGetId($insertData);

        return $id;
    }
}
