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
            // 'email' => '392@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('392'), // 社員番号+ランダム数字3桁
            'employee' => 392,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　伸',
            // 'email' => '618@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('618'), // 社員番号+ランダム数字3桁
            'employee' => 618,
            'factory_id' => 1,
            'department_id' => 2,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '今野 祐香',
            // 'email' => '506@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('506'), // 社員番号+ランダム数字3桁
            'employee' => 506,
            'factory_id' => 1,
            'department_id' => 2,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原　麻由子',
            // 'email' => '616@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('616'), // 社員番号+ランダム数字3桁
            'employee' => 616,
            'factory_id' => 1,
            'department_id' => 2,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤 友南',
            // 'email' => '682@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('682'), // 社員番号+ランダム数字3桁
            'employee' => 682,
            'factory_id' => 1,
            'department_id' => 2,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '岩淵 信之',
            // 'email' => '475@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('475'), // 社員番号+ランダム数字3桁
            'employee' => 475,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉 新治',
            // 'email' => '176@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('176'), // 社員番号+ランダム数字3桁
            'employee' => 176,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '沼倉　淳',
            // 'email' => '75@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('75'), // 社員番号+ランダム数字3桁
            'employee' => 75,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '木村 勝枝',
            // 'email' => '144@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('144'), // 社員番号+ランダム数字3桁
            'employee' => 144,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '那須野 定',
            // 'email' => '490@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('490'), // 社員番号+ランダム数字3桁
            'employee' => 490,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '齋藤 北斗',
            // 'email' => '574@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('574'), // 社員番号+ランダム数字3桁
            'employee' => 574,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '岩渕　昭一',
            // 'email' => '614@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('614'), // 社員番号+ランダム数字3桁
            'employee' => 614,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　健治',
            // 'email' => '706@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('706'), // 社員番号+ランダム数字3桁
            'employee' => 706,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　茂',
            // 'email' => '16@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('16'), // 社員番号+ランダム数字3桁
            'employee' => 16,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原 綾',
            // 'email' => '577@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('577'), // 社員番号+ランダム数字3桁
            'employee' => 577,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '岩渕　宏',
            // 'email' => '34@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('34'), // 社員番号+ランダム数字3桁
            'employee' => 34,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '阿部　敏久',
            // 'email' => '416@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('416'), // 社員番号+ランダム数字3桁
            'employee' => 416,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '岩淵 信之',
            // 'email' => '28@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('28'), // 社員番号+ランダム数字3桁
            'employee' => 28,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤 欣也',
            // 'email' => '69@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('69'), // 社員番号+ランダム数字3桁
            'employee' => 69,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '鈴木 良樹',
            // 'email' => '546@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('546'), // 社員番号+ランダム数字3桁
            'employee' => 546,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '猪岡 英宣',
            // 'email' => '552@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('552'), // 社員番号+ランダム数字3桁
            'employee' => 552,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　憲一',
            // 'email' => '570@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('570'), // 社員番号+ランダム数字3桁
            'employee' => 570,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '小松 勇児',
            // 'email' => '613@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('613'), // 社員番号+ランダム数字3桁
            'employee' => 613,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '小田中 秀樹',
            // 'email' => '635@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('635'), // 社員番号+ランダム数字3桁
            'employee' => 635,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '氏家　達也',
            // 'email' => '665@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('665'), // 社員番号+ランダム数字3桁
            'employee' => 665,
            'factory_id' => 1,
            'department_id' => 3,
            'group_id' => 3,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　誠',
            // 'email' => '411@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('411'), // 社員番号+ランダム数字3桁
            'employee' => 411,
            'factory_id' => 1,
            'department_id' => 1,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '金田 政樹',
            // 'email' => '302@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('302'), // 社員番号+ランダム数字3桁
            'employee' => 302,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '吉家 勝之',
            // 'email' => '17@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('17'), // 社員番号+ランダム数字3桁
            'employee' => 17,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原 富男',
            // 'email' => '177@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('177'), // 社員番号+ランダム数字3桁
            'employee' => 177,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '遠藤 悦子',
            // 'email' => '575@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('575'), // 社員番号+ランダム数字3桁
            'employee' => 575,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 4,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '渡辺　剛',
            // 'email' => '42@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('42'), // 社員番号+ランダム数字3桁
            'employee' => 42,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原 勝明',
            // 'email' => '68@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('68'), // 社員番号+ランダム数字3桁
            'employee' => 68,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '鈴木 立萍',
            // 'email' => '370@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('370'), // 社員番号+ランダム数字3桁
            'employee' => 370,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '田村 和之',
            // 'email' => '397@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('397'), // 社員番号+ランダム数字3桁
            'employee' => 397,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菊地 嵩斗',
            // 'email' => '565@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('565'), // 社員番号+ランダム数字3桁
            'employee' => 565,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '松田　伸一',
            // 'email' => '610@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('610'), // 社員番号+ランダム数字3桁
            'employee' => 610,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　花那',
            // 'email' => '698@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('698'), // 社員番号+ランダム数字3桁
            'employee' => 698,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            'birthday' => '5-18',
            ],
            [
            'name' => '小野寺 純',
            // 'email' => '259@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('259'), // 社員番号+ランダム数字3桁
            'employee' => 259,
            'factory_id' => 1,
            'department_id' => 4,
            'group_id' => 5,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '山本　恵子',
            // 'email' => '63@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('63'), // 社員番号+ランダム数字3桁
            'employee' => 63,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '渡辺　久美',
            // 'email' => '94@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('94'), // 社員番号+ランダム数字3桁
            'employee' => 94,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '米倉　美月',
            // 'email' => '631@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('631'), // 社員番号+ランダム数字3桁
            'employee' => 631,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 6,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '岩渕 てい子',
            // 'email' => '90@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('90'), // 社員番号+ランダム数字3桁
            'employee' => 90,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 7,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　優二',
            // 'email' => '249@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('249'), // 社員番号+ランダム数字3桁
            'employee' => 249,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 7,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　博',
            // 'email' => '334@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('334'), // 社員番号+ランダム数字3桁
            'employee' => 334,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 7,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　梢',
            // 'email' => '449@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('449'), // 社員番号+ランダム数字3桁
            'employee' => 449,
            'factory_id' => 1,
            'department_id' => 5,
            'group_id' => 7,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉 和俊',
            // 'email' => '488@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('488'), // 社員番号+ランダム数字3桁
            'employee' => 488,
            'factory_id' => 1,
            'department_id' => 6,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '小野 裕一',
            // 'email' => '51@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('51'), // 社員番号+ランダム数字3桁
            'employee' => 51,
            'factory_id' => 1,
            'department_id' => 6,
            'group_id' => 8,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '須藤三樹夫',
            // 'email' => '366@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('366'), // 社員番号+ランダム数字3桁
            'employee' => 366,
            'factory_id' => 1,
            'department_id' => 7,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '浅利　摩実',
            // 'email' => '201@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('201'), // 社員番号+ランダム数字3桁
            'employee' => 201,
            'factory_id' => 1,
            'department_id' => 7,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　寛子',
            // 'email' => '214@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('214'), // 社員番号+ランダム数字3桁
            'employee' => 214,
            'factory_id' => 1,
            'department_id' => 7,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '松井　むつみ',
            // 'email' => '640@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('640'), // 社員番号+ランダム数字3桁
            'employee' => 640,
            'factory_id' => 1,
            'department_id' => 7,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '蜂谷　昭子',
            // 'email' => '499@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('499'), // 社員番号+ランダム数字3桁
            'employee' => 499,
            'factory_id' => 1,
            'department_id' => 7,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '熊谷琴美',
            // 'email' => '724@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('724'), // 社員番号+ランダム数字3桁
            'employee' => 724,
            'factory_id' => 1,
            'department_id' => 8,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '八重樫美菜',
            // 'email' => '733@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('733'), // 社員番号+ランダム数字3桁
            'employee' => 733,
            'factory_id' => 1,
            'department_id' => 8,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '松本英之',
            // 'email' => '734@mailaddress.com', // 社員番号@mailaddress.com
            'password' => bcrypt('734'), // 社員番号+ランダム数字3桁
            'employee' => 734,
            'factory_id' => 1,
            'department_id' => 8,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            # 前沢工場
            [
            'name' => '佐藤　秀紀',
            'password' => bcrypt('425'), // 社員番号+ランダム数字3桁
            'employee' => 425,
            'factory_id' => 2,
            'department_id' => 1,
            'group_id' => 1,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '鈴木　和夫',
            'password' => bcrypt('398'), // 社員番号+ランダム数字3桁
            'employee' => 398,
            'factory_id' => 2,
            'department_id' => 9,
            'group_id' => 9,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '浅野　正弘',
            'password' => bcrypt('14'), // 社員番号+ランダム数字3桁
            'employee' => 14,
            'factory_id' => 2,
            'department_id' => 9,
            'group_id' => 9,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '金野　寛子',
            'password' => bcrypt('384'), // 社員番号+ランダム数字3桁
            'employee' => 384,
            'factory_id' => 2,
            'department_id' => 9,
            'group_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菊地　さとみ',
            'password' => bcrypt('278'), // 社員番号+ランダム数字3桁
            'employee' => 278,
            'factory_id' => 2,
            'department_id' => 9,
            'group_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '鈴木　綾海',
            'password' => bcrypt('699'), // 社員番号+ランダム数字3桁
            'employee' => 699,
            'factory_id' => 2,
            'department_id' => 9,
            'group_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千田　りん子',
            'password' => bcrypt('424'), // 社員番号+ランダム数字3桁
            'employee' => 424,
            'factory_id' => 2,
            'department_id' => 9,
            'group_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　潤',
            'password' => bcrypt('593'), // 社員番号+ランダム数字3桁
            'employee' => 593,
            'factory_id' => 2,
            'department_id' => 9,
            'group_id' => 10,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '永澤　祐太',
            'password' => bcrypt('339'), // 社員番号+ランダム数字3桁
            'employee' => 339,
            'factory_id' => 2,
            'department_id' => 6,
            'group_id' => 11,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '高橋　敏春',
            'password' => bcrypt('252'), // 社員番号+ランダム数字3桁
            'employee' => 252,
            'factory_id' => 2,
            'department_id' => 6,
            'group_id' => 11,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '石川　勝巳',
            'password' => bcrypt('503'), // 社員番号+ランダム数字3桁
            'employee' => 503,
            'factory_id' => 2,
            'department_id' => 6,
            'group_id' => 11,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '岩渕　涼音',
            'password' => bcrypt('623'), // 社員番号+ランダム数字3桁
            'employee' => 623,
            'factory_id' => 2,
            'department_id' => 6,
            'group_id' => 11,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '伊藤　皓揮',
            'password' => bcrypt('401'), // 社員番号+ランダム数字3桁
            'employee' => 401,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 12,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　貴志',
            'password' => bcrypt('248'), // 社員番号+ランダム数字3桁
            'employee' => 248,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 12,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '大内　涼',
            'password' => bcrypt('521'), // 社員番号+ランダム数字3桁
            'employee' => 521,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 12,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '加藤　優和',
            'password' => bcrypt('655'), // 社員番号+ランダム数字3桁
            'employee' => 655,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 12,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '小岩　肇',
            'password' => bcrypt('189'), // 社員番号+ランダム数字3桁
            'employee' => 189,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 13,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '柴田 恵美子',
            'password' => bcrypt('332'), // 社員番号+ランダム数字3桁
            'employee' => 332,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 13,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　花菜',
            'password' => bcrypt('703'), // 社員番号+ランダム数字3桁
            'employee' => 703,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 13,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　渓介',
            'password' => bcrypt('714'), // 社員番号+ランダム数字3桁
            'employee' => 714,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 13,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '阿部　将士',
            'password' => bcrypt('611'), // 社員番号+ランダム数字3桁
            'employee' => 611,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '高野　正博',
            'password' => bcrypt('419'), // 社員番号+ランダム数字3桁
            'employee' => 419,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菊地 宏輝',
            'password' => bcrypt('558'), // 社員番号+ランダム数字3桁
            'employee' => 558,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '丸山　善憲',
            'password' => bcrypt('677'), // 社員番号+ランダム数字3桁
            'employee' => 677,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '三浦　丈史',
            'password' => bcrypt('681'), // 社員番号+ランダム数字3桁
            'employee' => 681,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '八重樫　滉',
            'password' => bcrypt('707'), // 社員番号+ランダム数字3桁
            'employee' => 707,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '酒井　皇司',
            'password' => bcrypt('709'), // 社員番号+ランダム数字3桁
            'employee' => 709,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '阿部　瞳',
            'password' => bcrypt('634'), // 社員番号+ランダム数字3桁
            'employee' => 634,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '照井　吉次',
            'password' => bcrypt('694'), // 社員番号+ランダム数字3桁
            'employee' => 694,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 14,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '境澤　実知也',
            'password' => bcrypt('325'), // 社員番号+ランダム数字3桁
            'employee' => 325,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '細川　純',
            'password' => bcrypt('450'), // 社員番号+ランダム数字3桁
            'employee' => 450,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '因幡 浩幸',
            'password' => bcrypt('407'), // 社員番号+ランダム数字3桁
            'employee' => 407,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '吉田 洋次郎',
            'password' => bcrypt('454'), // 社員番号+ランダム数字3桁
            'employee' => 454,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原　孝春',
            'password' => bcrypt('587'), // 社員番号+ランダム数字3桁
            'employee' => 587,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　香奈',
            'password' => bcrypt('588'), // 社員番号+ランダム数字3桁
            'employee' => 588,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '三浦　楓花',
            'password' => bcrypt('657'), // 社員番号+ランダム数字3桁
            'employee' => 657,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　由佳',
            'password' => bcrypt('723'), // 社員番号+ランダム数字3桁
            'employee' => 723,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '及川蒼依',
            'password' => bcrypt('728'), // 社員番号+ランダム数字3桁
            'employee' => 728,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　賢一',
            'password' => bcrypt('693'), // 社員番号+ランダム数字3桁
            'employee' => 693,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐々木 仁美',
            'password' => bcrypt('716'), // 社員番号+ランダム数字3桁
            'employee' => 716,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤蓮太朗',
            'password' => bcrypt('732'), // 社員番号+ランダム数字3桁
            'employee' => 732,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 15,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千田　優太',
            'password' => bcrypt('569'), // 社員番号+ランダム数字3桁
            'employee' => 569,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '濁沼 さつき',
            'password' => bcrypt('213'), // 社員番号+ランダム数字3桁
            'employee' => 213,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '鈴木 まゆみ',
            'password' => bcrypt('363'), // 社員番号+ランダム数字3桁
            'employee' => 363,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '高橋 一也',
            'password' => bcrypt('391'), // 社員番号+ランダム数字3桁
            'employee' => 391,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '長前 秀幸',
            'password' => bcrypt('515'), // 社員番号+ランダム数字3桁
            'employee' => 515,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　孝',
            'password' => bcrypt('537'), // 社員番号+ランダム数字3桁
            'employee' => 537,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '丹野　美紗',
            'password' => bcrypt('636'), // 社員番号+ランダム数字3桁
            'employee' => 636,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '高橋 悦也',
            'password' => bcrypt('671'), // 社員番号+ランダム数字3桁
            'employee' => 671,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '西城　千香',
            'password' => bcrypt('715'), // 社員番号+ランダム数字3桁
            'employee' => 715,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐々木陽人',
            'password' => bcrypt('725'), // 社員番号+ランダム数字3桁
            'employee' => 725,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '小野寺美月',
            'password' => bcrypt('726'), // 社員番号+ランダム数字3桁
            'employee' => 726,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 16,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '加藤　武史',
            'password' => bcrypt('395'), // 社員番号+ランダム数字3桁
            'employee' => 395,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '高橋　知也',
            'password' => bcrypt('688'), // 社員番号+ランダム数字3桁
            'employee' => 688,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菊地　和哉',
            'password' => bcrypt('514'), // 社員番号+ランダム数字3桁
            'employee' => 514,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '沼田　庸弥',
            'password' => bcrypt('679'), // 社員番号+ランダム数字3桁
            'employee' => 679,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '三宅　敏典',
            'password' => bcrypt('687'), // 社員番号+ランダム数字3桁
            'employee' => 687,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '懸田　竜馬',
            'password' => bcrypt('708'), // 社員番号+ランダム数字3桁
            'employee' => 708,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '岩渕　颯',
            'password' => bcrypt('731'), // 社員番号+ランダム数字3桁
            'employee' => 731,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '高橋　誠一',
            'password' => bcrypt('721'), // 社員番号+ランダム数字3桁
            'employee' => 721,
            'factory_id' => 2,
            'department_id' => 10,
            'group_id' => 17,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原　千春',
            'password' => bcrypt('246'), // 社員番号+ランダム数字3桁
            'employee' => 246,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 18,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '伊藤　雪奈',
            'password' => bcrypt('702'), // 社員番号+ランダム数字3桁
            'employee' => 702,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 18,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原　優',
            'password' => bcrypt('701'), // 社員番号+ランダム数字3桁
            'employee' => 701,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 18,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '伊藤　祐',
            'password' => bcrypt('400'), // 社員番号+ランダム数字3桁
            'employee' => 400,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '阿部 真吾',
            'password' => bcrypt('92'), // 社員番号+ランダム数字3桁
            'employee' => 92,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原　悌',
            'password' => bcrypt('193'), // 社員番号+ランダム数字3桁
            'employee' => 193,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千葉　隆好',
            'password' => bcrypt('196'), // 社員番号+ランダム数字3桁
            'employee' => 196,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '三浦 　実',
            'password' => bcrypt('383'), // 社員番号+ランダム数字3桁
            'employee' => 383,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '千田　瀬成',
            'password' => bcrypt('541'), // 社員番号+ランダム数字3桁
            'employee' => 541,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原 佳己',
            'password' => bcrypt('582'), // 社員番号+ランダム数字3桁
            'employee' => 582,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '高橋　秀斗',
            'password' => bcrypt('624'), // 社員番号+ランダム数字3桁
            'employee' => 624,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '小部　裕',
            'password' => bcrypt('683'), // 社員番号+ランダム数字3桁
            'employee' => 683,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '菅原　巧',
            'password' => bcrypt('482'), // 社員番号+ランダム数字3桁
            'employee' => 482,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 2,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '小野寺　敏夫',
            'password' => bcrypt('6'), // 社員番号+ランダム数字3桁
            'employee' => 6,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 19,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '阿部 龍磨',
            'password' => bcrypt('406'), // 社員番号+ランダム数字3桁
            'employee' => 406,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 19,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
            [
            'name' => '佐藤　建樹',
            'password' => bcrypt('641'), // 社員番号+ランダム数字3桁
            'employee' => 641,
            'factory_id' => 2,
            'department_id' => 3,
            'group_id' => 19,
            'adoption_date' => $faker->dateTimeBetween('-10years', '-1years')->format('Y-m-d'),
            'birthday' => '5-18',
            ],
        ];
        
        DB::table('users')->insert($param);
    }
}
