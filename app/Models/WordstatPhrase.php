<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordstatPhrase extends Model
{
   protected $guarded = [];

   public function stats() {
    return $this->hasMany(WordstatPhraseStat::class, 'phrase_id', 'id')->where(['type' => 'monthly']);
   }
   public function stat() {
    return $this->hasOne(WordstatPhraseStat::class, 'phrase_id', 'id')->where(['type' => 'monthly']);
   }
   public function lastStat() {
    /*return $this->hasOne(WordstatPhraseStat::class, 'phrase_id', 'id')->where(['type' => 'monthly'])->where(function ($query) {
      $query->where('date', '=', date('Y-m-01', strtotime('-1 month')));
          //->orWhere('date', '=', date('Y-m-01', strtotime('-2 month')));
    });*/
    return $this->hasOne(WordstatPhraseStat::class, 'phrase_id', 'id')->where(['type' => 'monthly'])->where(function ($query) {
      $query->where('date', '=', date('Y-m-01', strtotime('-2 month')))
          ->orWhere('date', '=', date('Y-m-01', strtotime('-1 month')));
    })
    ->orderByDesc('date');
   }

   public function calcStats() {
    $hasDevicesStats = false;
    if($this->stat && $this->stat->desktop) $hasDevicesStats = true;

    $addStats = [];
      $addStats['all'] = WordstatPhraseStat::where(['phrase_id' => $this->id, 'type' => 'monthly'])->sum('value');
      // выявить пики
      //$addStats['max'] = WordstatPhraseStat::where(['phrase_id' => $this->id, 'type' => 'monthly'])->sum('value');
      $addStats['max'] = WordstatPhraseStat::where(['phrase_id' => $this->id, 'type' => 'monthly'])->orderByDesc('value')->first();
      $addStats['max_month'] = ruMonthFull2(strtotime($addStats['max']->date)) . " " . date('Y', strtotime($addStats['max']->date));
      $addStats['min'] = WordstatPhraseStat::where(['phrase_id' => $this->id, 'type' => 'monthly'])->orderBy('value')->first();
      $addStats['min_month'] = ruMonthFull2(strtotime($addStats['min']->date)) . " " . date('Y', strtotime($addStats['min']->date));
      // позже буду считать на устройствах
      if($hasDevicesStats) {
        $addStats['desktop'] = WordstatPhraseStat::where(['phrase_id' => $this->id, 'type' => 'monthly'])->sum('desktop');
        $addStats['tablet'] = WordstatPhraseStat::where(['phrase_id' => $this->id, 'type' => 'monthly'])->sum('tablet');
        $addStats['phone'] = WordstatPhraseStat::where(['phrase_id' => $this->id, 'type' => 'monthly'])->sum('phone');
        $addStats['desktop_percent'] = round(($addStats['desktop'] / $addStats['all']) * 100);
        $addStats['tablet_percent'] = round(($addStats['tablet'] / $addStats['all']) * 100);
        $addStats['phone_percent'] = round(($addStats['phone'] / $addStats['all']) * 100);
      }
      $addStats['ups_count'] = WordstatPhraseStat::where(['phrase_id' => $this->id])->where('percent_change', '>', 0)->count();
      $addStats['downs_count'] = WordstatPhraseStat::where(['phrase_id' => $this->id])->where('percent_change', '<', 0)->count();
    return $addStats;
   }
}
