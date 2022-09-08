<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_sheets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->string('responsible');
            $table->string('technical');
            $table->text('description');

            $table->foreignUuid('maintenance_type_id')->constrained('maintenance_types');
            $table->foreignUuid('supplier_id')->constrained('suppliers');
            $table->foreignUuid('machine_id')->constrained('machines');

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
        Schema::dropIfExists('maintenance_sheets');
    }
}
