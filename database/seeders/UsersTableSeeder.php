<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ja_JP');
        $param = [
            [
            'name' => '佐藤昭彦',
            'email' => '392@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('392'), // 社員番号+ランダム数字3桁
            'employee' => 392,
            'factory_id' => 1,
            'department_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉　伸',
            'email' => '618@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('618'), // 社員番号+ランダム数字3桁
            'employee' => 618,
            'factory_id' => 1,
            'department_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '今野 祐香',
            'email' => '506@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('506'), // 社員番号+ランダム数字3桁
            'employee' => 506,
            'factory_id' => 1,
            'department_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '菅原　麻由子',
            'email' => '616@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('616'), // 社員番号+ランダム数字3桁
            'employee' => 616,
            'factory_id' => 1,
            'department_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '佐藤 友南',
            'email' => '682@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('682'), // 社員番号+ランダム数字3桁
            'employee' => 682,
            'factory_id' => 1,
            'department_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '岩淵 信之',
            'email' => '475@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('475'), // 社員番号+ランダム数字3桁
            'employee' => 475,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉 新治',
            'email' => '176@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('176'), // 社員番号+ランダム数字3桁
            'employee' => 176,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '沼倉　淳',
            'email' => '75@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('75'), // 社員番号+ランダム数字3桁
            'employee' => 75,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '木村 勝枝',
            'email' => '144@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('144'), // 社員番号+ランダム数字3桁
            'employee' => 144,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '那須野 定',
            'email' => '490@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('490'), // 社員番号+ランダム数字3桁
            'employee' => 490,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '齋藤 北斗',
            'email' => '574@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('574'), // 社員番号+ランダム数字3桁
            'employee' => 574,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '岩渕　昭一',
            'email' => '614@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('614'), // 社員番号+ランダム数字3桁
            'employee' => 614,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '佐藤　健治',
            'email' => '706@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('706'), // 社員番号+ランダム数字3桁
            'employee' => 706,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉　茂',
            'email' => '16@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('16'), // 社員番号+ランダム数字3桁
            'employee' => 16,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '菅原 綾',
            'email' => '577@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('577'), // 社員番号+ランダム数字3桁
            'employee' => 577,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '岩渕　宏',
            'email' => '34@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('34'), // 社員番号+ランダム数字3桁
            'employee' => 34,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '阿部　敏久',
            'email' => '416@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('416'), // 社員番号+ランダム数字3桁
            'employee' => 416,
            'factory_id' => 1,
            'department_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '岩淵 信之',
            'email' => '28@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('28'), // 社員番号+ランダム数字3桁
            'employee' => 28,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '佐藤 欣也',
            'email' => '69@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('69'), // 社員番号+ランダム数字3桁
            'employee' => 69,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '鈴木 良樹',
            'email' => '546@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('546'), // 社員番号+ランダム数字3桁
            'employee' => 546,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '猪岡 英宣',
            'email' => '552@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('552'), // 社員番号+ランダム数字3桁
            'employee' => 552,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '佐藤　憲一',
            'email' => '570@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('570'), // 社員番号+ランダム数字3桁
            'employee' => 570,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '小松 勇児',
            'email' => '613@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('613'), // 社員番号+ランダム数字3桁
            'employee' => 613,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '小田中 秀樹',
            'email' => '635@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('635'), // 社員番号+ランダム数字3桁
            'employee' => 635,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '氏家　達也',
            'email' => '665@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('665'), // 社員番号+ランダム数字3桁
            'employee' => 665,
            'factory_id' => 1,
            'department_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '佐藤　誠',
            'email' => '411@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('411'), // 社員番号+ランダム数字3桁
            'employee' => 411,
            'factory_id' => 1,
            'department_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '金田 政樹',
            'email' => '302@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('302'), // 社員番号+ランダム数字3桁
            'employee' => 302,
            'factory_id' => 1,
            'department_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '吉家 勝之',
            'email' => '17@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('17'), // 社員番号+ランダム数字3桁
            'employee' => 17,
            'factory_id' => 1,
            'department_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '菅原 富男',
            'email' => '177@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('177'), // 社員番号+ランダム数字3桁
            'employee' => 177,
            'factory_id' => 1,
            'department_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '遠藤 悦子',
            'email' => '575@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('575'), // 社員番号+ランダム数字3桁
            'employee' => 575,
            'factory_id' => 1,
            'department_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '渡辺　剛',
            'email' => '42@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('42'), // 社員番号+ランダム数字3桁
            'employee' => 42,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '菅原 勝明',
            'email' => '68@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('68'), // 社員番号+ランダム数字3桁
            'employee' => 68,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '鈴木 立萍',
            'email' => '370@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('370'), // 社員番号+ランダム数字3桁
            'employee' => 370,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '田村 和之',
            'email' => '397@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('397'), // 社員番号+ランダム数字3桁
            'employee' => 397,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '菊地 嵩斗',
            'email' => '565@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('565'), // 社員番号+ランダム数字3桁
            'employee' => 565,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '松田　伸一',
            'email' => '610@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('610'), // 社員番号+ランダム数字3桁
            'employee' => 610,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉　花那',
            'email' => '698@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('698'), // 社員番号+ランダム数字3桁
            'employee' => 698,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '小野寺 純',
            'email' => '259@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('259'), // 社員番号+ランダム数字3桁
            'employee' => 259,
            'factory_id' => 1,
            'department_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '山本　恵子',
            'email' => '63@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('63'), // 社員番号+ランダム数字3桁
            'employee' => 63,
            'factory_id' => 1,
            'department_id' => 7,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '渡辺　久美',
            'email' => '94@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('94'), // 社員番号+ランダム数字3桁
            'employee' => 94,
            'factory_id' => 1,
            'department_id' => 7,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '米倉　美月',
            'email' => '631@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('631'), // 社員番号+ランダム数字3桁
            'employee' => 631,
            'factory_id' => 1,
            'department_id' => 7,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '岩渕 てい子',
            'email' => '90@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('90'), // 社員番号+ランダム数字3桁
            'employee' => 90,
            'factory_id' => 1,
            'department_id' => 8,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉　優二',
            'email' => '249@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('249'), // 社員番号+ランダム数字3桁
            'employee' => 249,
            'factory_id' => 1,
            'department_id' => 8,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉　博',
            'email' => '334@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('334'), // 社員番号+ランダム数字3桁
            'employee' => 334,
            'factory_id' => 1,
            'department_id' => 8,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉　梢',
            'email' => '449@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('449'), // 社員番号+ランダム数字3桁
            'employee' => 449,
            'factory_id' => 1,
            'department_id' => 8,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉 和俊',
            'email' => '488@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('488'), // 社員番号+ランダム数字3桁
            'employee' => 488,
            'factory_id' => 1,
            'department_id' => 9,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '小野 裕一',
            'email' => '51@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('51'), // 社員番号+ランダム数字3桁
            'employee' => 51,
            'factory_id' => 1,
            'department_id' => 9,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '須藤三樹夫',
            'email' => '366@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('366'), // 社員番号+ランダム数字3桁
            'employee' => 366,
            'factory_id' => 1,
            'department_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '浅利　摩実',
            'email' => '201@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('201'), // 社員番号+ランダム数字3桁
            'employee' => 201,
            'factory_id' => 1,
            'department_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '千葉　寛子',
            'email' => '214@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('214'), // 社員番号+ランダム数字3桁
            'employee' => 214,
            'factory_id' => 1,
            'department_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '松井　むつみ',
            'email' => '640@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('640'), // 社員番号+ランダム数字3桁
            'employee' => 640,
            'factory_id' => 1,
            'department_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '蜂谷　昭子',
            'email' => '499@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('499'), // 社員番号+ランダム数字3桁
            'employee' => 499,
            'factory_id' => 1,
            'department_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '熊谷琴美',
            'email' => '724@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('724'), // 社員番号+ランダム数字3桁
            'employee' => 724,
            'factory_id' => 1,
            'department_id' => 11,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '八重樫美菜',
            'email' => '733@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('733'), // 社員番号+ランダム数字3桁
            'employee' => 733,
            'factory_id' => 1,
            'department_id' => 11,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
            [
            'name' => '松本英之',
            'email' => '734@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('734'), // 社員番号+ランダム数字3桁
            'employee' => 734,
            'factory_id' => 1,
            'department_id' => 11,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            ],
        ];
        
        DB::table('users')->insert($param);
    }
}
