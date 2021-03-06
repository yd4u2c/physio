<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrtPage3sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ort_page3s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sys_num')->nullable();
            $table->string('rec')->nullable();
            $table->string('worse')->nullable();
            $table->string('best')->nullable();
            $table->string('current')->nullable();
            $table->string('duration')->nullable();
            $table->string('aggravating')->nullable();
            $table->string('alleviating')->nullable();
            $table->string('behavior')->nullable();
            $table->string('medication')->nullable();
            $table->string('home')->nullable();
            $table->string('measure')->nullable();
            $table->string('join')->nullable();
            $table->string('flexibility')->nullable();
            $table->string('situation')->nullable();
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
        Schema::dropIfExists('ort_page3s');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     