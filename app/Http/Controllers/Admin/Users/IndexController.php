<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;


class IndexController extends Controller
{
    public function index()
    {     
        $items=User::all();

        return view('admin.user.index', compact('items'));
    }
}
