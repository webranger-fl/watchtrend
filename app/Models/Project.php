<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Concerns\UsesUuid;

class Project extends Model
{
  use UsesUuid;
   protected $guarded = [];

  public function phrases() {
    return $this->belongsToMany(WordstatPhrase::class, 'project_phrases', 'project_id', 'phrase_id', 'id', 'id');
  }

}
