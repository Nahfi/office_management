<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form')->nullable();
            $table->unsignedBigInteger('to')->nullable();
            $table->unsignedBigInteger('employee_form')->nullable();
            $table->unsignedBigInteger('employee_to')->nullable();
            $table->string('slug');
            $table->string('subject')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->default('unread');
            $table->string('soft_deleted_by_sender')->nullable();
            $table->string('permanent_deleted_by_sender')->nullable();
            $table->string('soft_deleted_by_receiver')->nullable();
            $table->string('permanent_deleted_by_receiver')->nullable();
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
        Schema::dropIfExists('emails');
    }
}
