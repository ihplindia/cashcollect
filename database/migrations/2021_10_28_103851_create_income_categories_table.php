<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_categories', function (Blueprint $table) {
            $table->bigIncrements('incate_id');
            $table->string('incate_name',100)->unique();
            $table->text('incate_remarks')->nullable();
            $table->integer('incate_creator')->nullable();
            $table->integer('inncate_editor')->nullable();
            $table->string('incate_slug',50)->nullable();
            $table->integer('incate_status')->default(1);
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
        Schema::dropIfExists('income_categories');
    }
}
