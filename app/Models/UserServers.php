<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserServers extends Model
{
    use HasFactory;

    const TABLE_NAME = 'user_servers';

    public function getUserServers(array $columnName, array $codition)
    {
        return $this->selectUserData($columnName, $codition);
    }

    public function setUserServers(array $insertData = [])
    {
        return $this->createUserData($insertData);
    }

    private function selectUserData(array $columnName = ['*'], array $condition = [])
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
}
