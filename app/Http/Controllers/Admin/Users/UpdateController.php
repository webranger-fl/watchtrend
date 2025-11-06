<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;


class UpdateController extends Controller
{
    public function index(User $user)
    {
        $data=request()->validate(['name'=>'required|string', 'email'=>'required|string', 'role'=>'required|string']);

        $user->update($data);

        return redirect()->route('admin.user.show', $user->id);
    }
}
