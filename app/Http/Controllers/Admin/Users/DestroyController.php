<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;


class DestroyController extends Controller
{
    public function index(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('msg', 'Пользователь удален');
    }
}
