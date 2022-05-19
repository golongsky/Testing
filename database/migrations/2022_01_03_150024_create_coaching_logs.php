<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachingLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaching_logs', function (Blueprint $table) {
            $table->id();
            $table->date('coaching_date');
            $table->string('title');
            $table->longText('description');
            $table->longText('documents');
            $table->longText('surveys');
            $table->string('status');
            $table->integer('team_lead_id');
            $table->integer('agent_id');
            $table->longText('reason');
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
        Schema::dropIfExists('coaching_logs');
    }
}
