<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_problems', function (Blueprint $table) {
            $table->id();
            $table->integer('machine_id');
            $table->string('code');
            $table->string('symton_noise');
            $table->string('causing_part');
            $table->string('area');
            $table->string('method');
            $table->string('at_gear')->nullable();
            $table->string('diagram_image');
            $table->string('sound');
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
        Schema::dropIfExists('machine_problems');
    }
}
