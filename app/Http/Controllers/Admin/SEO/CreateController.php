<?php

namespace App\Http\Controllers\Admin\SEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Seo;


class CreateController extends Controller
{
    public function index()
    {

        return view('admin.seo.create');
    }
}
