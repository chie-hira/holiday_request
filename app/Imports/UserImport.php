<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable; //追加
use Maatwebsite\Excel\Concerns\WithHeadingRow; //追加

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable;

    public function model(array $row)
    {
        return new User([
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'employee' => $row['employee'],
            'affiliation_id' => $row['affiliation_id'],
            'adoption_date' => $row['adoption_date'],
            'birthday' => $row['birthday'],
            'remarks' => $row['remarks'],
        ]);
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
