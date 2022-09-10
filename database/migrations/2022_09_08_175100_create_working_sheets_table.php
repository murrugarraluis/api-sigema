<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_sheets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->text('description');
            $table->foreignUuid('machine_id')->constrained('machines');
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
        Schema::dropIfExists('working_sheets');
    }
}
