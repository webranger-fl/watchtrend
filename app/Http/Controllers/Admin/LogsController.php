<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SiteRequest;
use App\Models\NotFoundHit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{

    public function logsNotFound()
    {
      
      $items = NotFoundHit::latest()->paginate(50);

      return view('admin.logs.notFound', compact('items'));
    }

}
