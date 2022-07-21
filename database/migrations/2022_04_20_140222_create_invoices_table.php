<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->float('sub_total')->nullable();
            $table->string('discount_type');
            $table->integer('discount')->nullable();
            $table->integer('tax')->nullable();
            $table->float('grand_total')->nullable();
            $table->float('amount_paid')->nullable();
            $table->float('total_due')->nullable();
            $table->date('due_date')->nullable();
            $table->longText('note')->nullable();
            $table->longText('comments')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
