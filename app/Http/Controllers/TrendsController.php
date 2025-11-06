<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seo;
use App\Models\WordstatPhrase;
use App\Models\WordstatPhraseStat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
//use Stevebauman\Location\Facades\Location;
use App\Helpers\Telegram;

class TrendsController extends Controller
{
    public function index(Request $req)
    {
      $stats = WordstatPhraseStat::where(['date' => '2025-10-01'])->orderByDesc('percent_change')->with('phrase')->limit(20)->get();
      //dd($stats);
      return view('trends', compact('stats'));
    }


    
}
