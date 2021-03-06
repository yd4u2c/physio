<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNeuPage3sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neu_page3s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sys_num');
            $table->string('rec');
            $table->string('alert');
            $table->string('resp');
            $table->string('cognition');
            $table->string('cognition2');
            $table->string('neglect');
            $table->string('comm');
            $table->string('swallow');
            $table->string('pain');
            $table->string('bed');
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
        Schema::dropIfExists('neu_page3s');
    }
}
                                                     