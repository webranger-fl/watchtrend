<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\IndexNowRequest;



class IndexNowController extends Controller
{
    public function index()
    {
        $items=IndexNowRequest::filtered()->orderByDesc('id')->paginate(50);

        return view('admin.indexnow.index', compact('items'));
    }

}
