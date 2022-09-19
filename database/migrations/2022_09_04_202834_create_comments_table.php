<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('评论的用户');
            $table->integer('goods_id')->comment('所属商品');
            $table->tinyInteger('rate')->default(1)->comment("评论的级别：1好评 2中评 3差评");
            $table->string('content')->comment('评论内容');
            $table->string('reply')->nullable()->comment('商家回复');
            $table->json('pics')->nullable()->comment('评论图集');
            $table->timestamps();
            $table->index('goods_id');
            $table->index('rate');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
