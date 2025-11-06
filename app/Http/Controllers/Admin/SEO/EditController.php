<?php

namespace App\Http\Controllers\Admin\SEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Seo;


class EditController extends Controller
{
    public function index(Seo $seo)
    {


        return view('admin.seo.edit', compact('seo'));
    }
}
