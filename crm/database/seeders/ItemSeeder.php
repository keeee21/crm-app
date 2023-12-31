<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => '商品A',
                'memo' => 'メモA',
                'price' => 100,
                'is_selling' => true
            ],
            [
                'name' => '商品B',
                'memo' => 'メモB',
                'price' => 200,
                'is_selling' => true
            ],
            [
                'name' => '商品C',
                'memo' => 'メモC',
                'price' => 300,
                'is_selling' => false
            ],
            [
                'name' => '商品D',
                'memo' => 'メモD',
                'price' => 400,
                'is_selling' => true
            ],
            [
                'name' => '商品E',
                'memo' => 'メモE',
                'price' => 500,
                'is_selling' => false
            ],
        ]);
    }
}
