<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('document_number');
            $table->string('name');
            $table->string('lastname');
            $table->string('perosnal_email');
            $table->string('phone');
            $table->string('address');
            $table->timestamps();

//            FK
            $table->foreignUuid('user_id')->nullable()->constrained('users');
            $table->foreignUuid('position_id')->constrained('positions');
            $table->foreignUuid('document_type_id')->constrained('document_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
