<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_sheets', function (Blueprint $table) {
            $table->uuid('id')->primary();
//            $table->string('registration_number');
            $table->date('date');
//            $table->time('time_start');
//            $table->time('time_end');
            $table->string('responsible');
            $table->boolean('status')->default(1); //  CLOSED=0; OPEN= 1
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_sheets');
    }
}
