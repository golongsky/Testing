<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachingFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaching_form', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->text('form_description');
            $table->string('form_created_by');
            $table->string('form_control_id');
            $table->integer('form_type'); //1 = intake 2 = inhouse 3 = google 4 = asses 5 = eval 6 = session
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
        Schema::dropIfExists('coaching_form');
    }
}
