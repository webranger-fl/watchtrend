<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class StoreController extends Controller
{
    public function index(Request $req)
    {
        $data=$req->validate(['name'=>'required|string', 'email'=>'required|string', /*'role'=>'required|string'*/]);

        $password = Str::random(10);

        $data['password'] = Hash::make($password);
        //dd($data);

        User::create($data);

        $user = User::where(['name' => $req->name])->first();
        //dd($user);

        return redirect()->route('admin.user.index')->with('stickyMsg', "Пароль созданного пользователя: $password Сохраните пароль!");
    }

    public function regenPass(Request $req, User $user) {
        $session = DB::table('sessions')->whereUserId($user->id)->first();
        //dd($session);
        //dd($user);
        //dd($user->session);
        $password = Str::random(10);
        $user->password = Hash::make($password);
        $user->update();
        // по идее это разлогинит
        //$session->delete();
        DB::table('sessions')->whereUserId($user->id)->delete();
        
        // это инвалидация сессии текущего юзера, а надо 
        // https://www.dev-notes.ru/articles/laravel/invalidating-sessions-on-other-devices/
        // Auth::guard('web')->logout();
        //$request->session()->invalidate();
        //$request->session()->regenerateToken();

        return redirect()->route('admin.user.index')->with('stickyMsg', "Новый пароль пользователя $user->name: $password Сохраните пароль!");
    }
}
