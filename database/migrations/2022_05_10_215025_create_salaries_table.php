<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('working_day_id');
            $table->dateTime('date');
            $table->unsignedDouble('basic_salary');
            $table->unsignedDouble('per_day_salary');
            $table->integer('total_present');
            $table->integer('total_absent');
            $table->unsignedDouble('payable_salary')->default(0);
            $table->unsignedDouble('punishment')->default(0);
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('salaries');
    }
}
