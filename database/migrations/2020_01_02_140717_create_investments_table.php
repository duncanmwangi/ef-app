<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('investment_vehicle_id');
            $table->foreign('investment_vehicle_id')->references('id')->on('investment_vehicles');
            $table->enum('status',['PENDING', 'PROCESSING','APPROVED','DECLINED'])->default('PENDING');
            $table->decimal('amount', 10, 2);
            $table->text('admin_notes')->nullable();
            $table->text('investor_notes')->nullable();
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
        Schema::dropIfExists('investments');
    }
}
