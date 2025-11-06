<?php

namespace App\Http\Controllers\Admin\SEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Seo;


class DestroyController extends Controller
{
    public function index(Seo $seo)
    {
        $seo->delete();
        return redirect()->route('admin.seo.index');
    }
}
