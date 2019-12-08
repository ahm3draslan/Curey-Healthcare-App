<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->string('medicine_name', 50)->nullable(false);
            $table->string('dosage', 50);
            $table->unsignedInteger('days_interval')->default('0');
            $table->unsignedInteger('hours_interval');
            $table->time('start_hour');
            $table->timestamps();

//            Constraints
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}