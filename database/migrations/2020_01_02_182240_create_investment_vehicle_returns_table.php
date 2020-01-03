<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentVehicleReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_vehicle_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('investment_vehicle_id');
            $table->string('title');
            $table->decimal('percent_return', 5, 2);
            $table->enum('status',['PENDING', 'ISSUED'])->default('PENDING');
            $table->dateTime('date_to_issue');
            $table->dateTime('date_issued')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->foreign('investment_vehicle_id')->references('id')->on('investment_vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment_vehicle_returns');
    }
}
