<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerfRequest extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function scopeFiltered(Builder $query): void
    {
      //$query->where(['city' => config('app.city')]);      
    }

    public function scopeToday(Builder $query): void
  {
    $query->whereDate('created_at', DB::raw('CURDATE()'));
  }

  public function scopeLastSevenDays($query) {
    return $query->whereDate('created_at', '>', now()->subDays(7));
  }

  public function scopeLastMonth($query) {
    return $query->whereDate('created_at', '>', now()->subDays(30));
  }

  /*public function scopeTodayOrAnyDate(Builder $query, $date = null): void
  {
    if (!$date) $query->whereDate('created_at', DB::raw('CURDATE()'));
    else $query->whereDate('created_at', date("Y-m-d", strtotime($date)));
  }*/
}
