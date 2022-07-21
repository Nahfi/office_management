<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLeaveDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leave_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_leave_id');
            $table->integer('month');
            $table->integer('total_monthly_leave')->default(0);
            $table->integer('total_monthly_leave_remaining')->default(0);
            $table->string('created_by');
            $table->string('edited_by')->nullable();
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
        Schema::dropIfExists('employee_leave_details');
    }
}
