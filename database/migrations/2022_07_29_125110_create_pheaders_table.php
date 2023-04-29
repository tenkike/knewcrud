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
        Schema::create('vk_headers', function (Blueprint $table) {
       
        $table->id();
        $table->unsignedBigInteger('id_header')->unique()->index()->comment('comment:attribute');
        $table->string('h_title', 120)->index()->unique()->comment('comment:attribute');
        $table->text('h_description')->comment('comment:attribute');
	    $table->text('h_url_img')->nullable()->comment('comment:attribute');
	    $table->timestamps();

	    $table->foreign('id_header')->references('id')->on('vk_titles')->onUpdate('cascade')->onDelete('cascade');

        });

        $statement = "ALTER TABLE vk_headers AUTO_INCREMENT = 3000;";
            DB::unprepared($statement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vk_headers');
    }
};
