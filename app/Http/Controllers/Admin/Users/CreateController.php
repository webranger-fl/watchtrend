<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;


class CreateController extends Controller
{
    public function index()
    {
      $fields = [
        ['title' => 'Имя', 'key' => 'name', 'type' => 'text', 'required' => true],
        ['title' => 'Email', 'key' => 'email', 'type' => 'email', 'required' => true],
        ['title' => 'Пароль', 'key' => 'password', 'type' => 'password', 'required' => true],
      ];
        return view('admin.user.create', compact('fields'));
    }
}
