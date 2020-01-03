<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('investment_vehicle_return_id');
            $table->unsignedBigInteger('investment_id');
            $table->decimal('amount', 10, 2);
            $table->enum('status',['ISSUED','APPROVED','DECLINED'])->default('ISSUED');
            $table->dateTime('date_issued')->nullable();
            $table->dateTime('date_approved')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->foreign('investment_vehicle_return_id')->references('id')->on('investment_vehicle_returns');
            $table->foreign('investment_id')->references('id')->on('investments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('earnings');
    }
}
