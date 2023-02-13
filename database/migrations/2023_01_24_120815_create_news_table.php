<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //  title とbody とimage_pathを追記
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            // historiesテーブルのnews_idに関連づけ
            $table->string('title'); //ニュースのタイトルを保存
            $table->string('body'); //ニュースの本文を保存
            $table->string('image_path')->nullable(); //画像のパスを保存。空でも保存可能
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
