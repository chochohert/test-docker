<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->set("status",['processed','refunded','shipped','completed'])->default("processed")->comment("주문 상태");
            $table->foreignId("user_id");
            $table->integer("total_price")->comment("총 결제 가격");
            $table->timestamp("refunded_at")->nullable()->comment("환불 일자");
            $table->timestamp("confirmed_at")->nullable()->comment("구매 확정일자");
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
        Schema::dropIfExists('orders');
    }
}
