<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WordstatPhrase;
use App\Models\WordstatPhraseStat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WordstatController extends Controller
{

    public function status()
    {
        $req = Http::wordstatAPI()->post("/v1/userInfo");
        $body = json_decode($req->body());
        //dd($body);

        return view('admin.wordstat.status', compact('body'));
    }

   
}
