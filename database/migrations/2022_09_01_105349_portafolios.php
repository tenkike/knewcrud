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
        Schema::create('vk_portafolios', function (Blueprint $table) {
           // $table->autoIncrement(8000);
            $table->id();
            $table->unsignedBigInteger('id_category_port')->index()->unsigned();
            $table->unsignedBigInteger('id_subcat_port')->index()->unsigned()->nullable();
            $table->unsignedBigInteger('id_body_port')->index()->unsigned()->comment('comment:attribute');

            $table->enum('port_status', ['0', '1'])->default(0)->comment('comment:attribute');
            $table->string('port_title', 120)->index()->unique()->comment('comment:attribute');
            $table->string('port_subtitle', 120)->comment('comment:attribute');
            $table->float('port_qty', 8, 2)->default(0)->comment('comment:attribute');
            $table->float('port_dto', 8, 2)->default(0)->comment('comment:attribute');
            $table->decimal('port_price', 8, 2)->default(0)->comment('comment:attribute');
            $table->decimal('port_price_vp', 8, 2)->default(0)->comment('comment:attribute');
            $table->text('port_description')->comment('comment:attribute');
            $table->text('port_nameseo')->comment('comment:attribute');
            $table->timestamps();

            $table->foreign('id_category_port')->references('id')->on('vk_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_subcat_port')->references('id')->on('vk_subcategories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_body_port')->references('id')->on('vk_bodys')->onUpdate('cascade')->onDelete('cascade');
            
    });

            $statement = "ALTER TABLE vk_portafolios AUTO_INCREMENT = 6000;";
            DB::unprepared($statement);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vk_portafolios');
    }
};
