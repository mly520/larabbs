<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categoies = [
            [
                'name' => '共有',
                'description' => '書いて、見つかってシェア'
            ],
            [
                'name' => '教程',
                'description' => '開発テクニク、おすすめ拡張パッケージ'
            ],
            [
                'name' => '質問応答',
                'description' => 'お互いを助けあって、友好なコミュニティをつくろう'
            ],
            [
                'name' => 'お知らせ',
                'description' => 'サイトのお知らせ'
            ],
        ];
        DB::table('categories')->insert($categoies);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
