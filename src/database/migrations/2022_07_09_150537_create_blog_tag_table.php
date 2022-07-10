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
    public function up()
    {
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignId('blog_id');
            $table->foreignId('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_tag', function (Blueprint $table) {
            $table->dropForeign(['blog_id', 'tag_id']);
        });
        Schema::dropIfExists('blog_tag');
    }
};
