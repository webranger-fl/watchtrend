<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordstatPhraseStat extends Model
{
  protected $guarded = [];

  public function phrase() {
    return $this->belongsTo(WordstatPhrase::class, 'phrase_id', 'id');
   }

}
