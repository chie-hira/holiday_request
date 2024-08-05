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
                'name' => '部門一部長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 100,
                'affiliation_id' => 2,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門一いち課長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 110,
                'affiliation_id' => 3,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門一いち係長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 111,
                'affiliation_id' => 3,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門一いち課員',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 112,
                'affiliation_id' => 3,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門一に課長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 120,
                'affiliation_id' => 4,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門一に係長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 121,
                'affiliation_id' => 4,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門一に課員',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 122,
                'affiliation_id' => 4,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門二部長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 200,
                'affiliation_id' => 5,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門二いち課長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 210,
                'affiliation_id' => 6,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門二いち係長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 211,
                'affiliation_id' => 6,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門二いち課員',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 212,
                'affiliation_id' => 6,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門二に課長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 220,
                'affiliation_id' => 7,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門二に係長',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 221,
                'affiliation_id' => 7,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
            [
                'name' => '部門二に課員',
                'email' => 'hoge@mail.com',
                'password' => bcrypt('password'),
                'employee' => 222,
                'affiliation_id' => 7,
                'adoption_date' => '2000-1-1',
                'birthday' => '01-01',
            ],
        ];
        DB::table('users')->insert($param);
    }
}
