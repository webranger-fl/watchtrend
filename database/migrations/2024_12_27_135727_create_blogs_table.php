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
    Schema::create('blogs', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedMediumInteger('category_id');
      $table->string('title');
      $table->text('headline')->nullable();
      $table->string('slug');
      $table->string('thumb')->nullable();
      $table->mediumText('content');
      $table->string('seo_title')->nullable();
      $table->string('meta_desc')->nullable();
      $table->string('short_title')->nullable();
      $table->boolean('active')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blogs');
  }
};
