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
        Schema::create('vk_images', function (Blueprint $table) {
          //  $table->autoIncrement(5000);
            $table->id();
            $table->unsignedBigInteger('id_image')->index()->comment('comment:attribute');
            $table->string('i_title', 80)->index()->unique()->comment('comment:attribute');
            $table->text('i_description')->comment('comment:attribute');
            $table->text('i_url_img')->nullable()->comment('comment:attribute');
            $table->timestamps();

            $table->foreign('id_image')->references('id')->on('vk_titles')->onUpdate('cascade')->onDelete('cascade');
        });

        $statement = "ALTER TABLE vk_images AUTO_INCREMENT = 5000;";
            DB::unprepared($statement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vk_images');
    }
};
