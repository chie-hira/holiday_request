<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // これはインポートする
        $param = [
            [
                'name' => 'ユーザー1',
                'email' => 'app.sample.001@gmail.com',
                'password' => bcrypt(1),
                'employee' => 1,
                'affiliation_id' => 1,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => 'ユーザー2',
                'email' => 'app.sample.001@gmail.com',
                'password' => bcrypt(2),
                'employee' => 2,
                'affiliation_id' => 2,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
        ];

        DB::table('users')->insert($param);
    }
}
