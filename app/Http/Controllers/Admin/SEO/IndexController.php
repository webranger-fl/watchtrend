<?php

namespace App\Http\Controllers\Admin\SEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Seo;



class IndexController extends Controller
{
    public function index()
    {
        
        $seos=Seo::all();


        return view('admin.seo.index', compact('seos'));
    }
}
