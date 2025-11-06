<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('wordstat_phrase_stats', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('phrase_id');
      $table->string('date');
      $table->unsignedInteger('value');
      $table->string('type');
      $table->unsignedInteger('desktop')->nullable();
      $table->unsignedInteger('tablet')->nullable();
      $table->unsignedInteger('phone')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('wordstat_phrase_stats');
  }
};
