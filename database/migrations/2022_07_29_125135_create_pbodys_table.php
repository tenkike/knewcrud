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
        Schema::create('vk_bodys', function (Blueprint $table) {
    
        $table->id();
        $table->unsignedBigInteger('id_body')->unique()->index()->comment('comment:attribute');
        $table->string('b_title', 80)->index()->unique()->comment('comment:attribute');
        $table->text('b_description')->comment('comment:attribute');
        $table->text('b_url_img')->nullable()->comment('comment:attribute');
        $table->timestamps();

        $table->foreign('id_body')->references('id')->on('vk_titles')->onUpdate('cascade')->onDelete('cascade');
        });

        $statement = "ALTER TABLE vk_bodys AUTO_INCREMENT = 2000;";
            DB::unprepared($statement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vk_bodys');
    }
};
