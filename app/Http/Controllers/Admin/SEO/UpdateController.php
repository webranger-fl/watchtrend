<?php

namespace App\Http\Controllers\Admin\SEO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Seo;


class UpdateController extends Controller
{
    public function index(Seo $seo)
    {

        $data=request()->all();

        $seo->update($data);

        return redirect()->route('admin.seo.show', $seo->id);
    }
}
