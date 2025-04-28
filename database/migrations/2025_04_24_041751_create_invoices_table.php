<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('customer_id');
            $table->string('user_id');
            $table->unsignedBigInteger('refer_invoice_id')->default(0);
            $table->date('invoice_date')->nullable();
            $table->date('inspection_date')->nullable();
            $table->date('next_inspection_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->decimal('total_amount')->default(0);
            $table->decimal('paid_amount')->default(0);
            $table->decimal('due_amount')->default(0);
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('report')->nullable();
            $table->text('invoice_note');

            $table->integer('payment_status')->default(0)->comment('paid=1, unpaid=0, partial-paid=2');

            $table->tinyInteger('status')->default(1)->comment('1=active,0=inactive');
            $table->timestamp('created_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->tinyInteger('deleted')->default(0)->comment("1=deleted,0=active");
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('invoices');
    }
};
