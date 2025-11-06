<?php

namespace App\Http\Controllers\Admin\SEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Seo;

class StoreController extends Controller
{
    public function index()
    {
        $data=request()->all();

        Seo::create($data);

        return redirect()->route('admin.seo.index');
    }
}
