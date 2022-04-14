<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('_id');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('_id')->on('customers');
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id')->references('_id')->on('payment_methods');
            $table->float('total_price');
            $table->float('subtotal_price');
            $table->date('date');
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
        Schema::dropIfExists('sales');
    }
}
