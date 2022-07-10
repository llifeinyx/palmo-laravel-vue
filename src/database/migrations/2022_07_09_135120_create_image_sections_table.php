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
        Schema::create('image_sections', function (Blueprint $table) {
            $table->id();

            $table->string('path');

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

        Schema::dropIfExists('image_sections');
    }
};
