<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'price' => '15000',
            'image' => 'Armani+Mens+Clock.jpg',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition_id' => '1',
            'seller_id' => '1'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'HDD',
            'price' => '5000',
            'image' => 'HDD+Hard+Disk.jpg',
            'description' => '高速で信頼性の高いハードディスク',
            'condition_id' => '2',
            'seller_id' => '1'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '玉ねぎ3束',
            'price' => '300',
            'image' => 'iLoveIMG+d.jpg',
            'description' => '新鮮な玉ねぎ3束のセット',
            'condition_id' => '3',
            'seller_id' => '1'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '革靴',
            'price' => '4000',
            'image' => 'Leather+Shoes+Product+Photo.jpg',
            'description' => 'クラシックなデザインの革靴',
            'condition_id' => '4',
            'seller_id' => '1'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ノートPC',
            'price' => '45000',
            'image' => 'Living+Room+Laptop.jpg',
            'description' => '高性能なノートパソコン',
            'condition_id' => '1',
            'seller_id' => '1'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'マイク',
            'price' => '8000',
            'image' => 'Music+Mic+4632231.jpg',
            'description' => '高音質のレコーディング用マイク',
            'condition_id' => '2',
            'seller_id' => '2'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'image' => 'Purse+fashion+pocket.jpg',
            'description' => 'おしゃれなショルダーバッグ',
            'condition_id' => '3',
            'seller_id' => '2'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'タンブラー',
            'price' => '500',
            'image' => 'Tumbler+souvenir.jpg',
            'description' => '使いやすいタンブラー',
            'condition_id' => '4',
            'seller_id' => '2'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'コーヒーミル',
            'price' => '4000',
            'image' => 'Waitress+with+Coffee+Grinder.jpg',
            'description' => '手動のコーヒーミル',
            'condition_id' => '1',
            'seller_id' => '2'
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'メイクセット',
            'price' => '2500',
            'image' => '外出メイクアップセット.jpg',
            'description' => '便利なメイクアップセット',
            'condition_id' => '2',
            'seller_id' => '2'
        ];
        DB::table('items')->insert($param);
    }
}
