<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
      Schema::table('teams', function (Blueprint $table) {
        $table->foreignId('current_period_id')->index()->nullable();
      });
    }
};
