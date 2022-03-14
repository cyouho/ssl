<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Servers extends Model
{
    use HasFactory;

    const TABLE_NAME = 'servers';

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
