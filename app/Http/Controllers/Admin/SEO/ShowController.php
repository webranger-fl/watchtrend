<?php

namespace App\Http\Controllers\Admin\SEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Seo;


class ShowController extends Controller
{
    public function index(Seo $seo)
    {

        return view('admin.seo.show', compact('seo'));
    }
}
