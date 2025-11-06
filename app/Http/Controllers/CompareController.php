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

class CompareController extends Controller
{
    public function index(Request $req)
    {
      dd(1);
      $key1 = WordstatPhrase::where(['slug' => $req->slug1])->with('stats')->with('stat')->first();
      $key2 = WordstatPhrase::where(['slug' => $req->slug2])->with('stats')->with('stat')->first();
      $key1->stats = $key1->calcStats();
      $key2->stats = $key2->calcStats();

      return view('compare', compact('key1', 'key2'));
    }


    
}
