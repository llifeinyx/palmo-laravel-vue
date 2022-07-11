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
        Schema::create('text_sections', function (Blueprint $table) {
            $table->id();

            $table->text('text');
            $table->text('header');

            $table->integer('index');

            $table->foreignId('blog_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('text_sections', function (Blueprint $table) {
           $table->dropForeign(['blog_id']);
        });

        Schema::dropIfExists('text_sections');
    }
};
