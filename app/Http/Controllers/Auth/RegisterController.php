<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNeuPage1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neu_page1s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sys_num');
            $table->string('rec');
            $table->string('name');
            $table->string('address');
            $table->string('diagnosis');
            $table->string('nhis_no');
            $table->string('hosp_no');
            $table->string('dob');
            $table->string('gender');
            $table->string('phone');
            $table->string('admission');
            $table->string('consent');
            $table->string('signature');
            $table->string('date');
            $table->string('time');
            $table->string('print');
            $table->string('designation');
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
        Schema::dropIfExists('neu_page1s');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  