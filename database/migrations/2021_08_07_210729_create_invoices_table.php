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
            $table->bigIncrements('id');
            $table->string('invoice_number', 50);
            $table->date('invoice_date');
            $table->date('due_date');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('section_id');
            $table->decimal('Amount_collection')->nullable();
            $table->decimal('Amount_Commission');
            $table->decimal('discount');
            $table->decimal('rate_vat');
            $table->decimal('value_vat');
            $table->decimal('total');
            $table->enum('value_status',[1,2,3]);
            $table->text('note')->nullable();
            $table->string('created_by', 100);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
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
