<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\Hadith\HadithRepositoryInterface;
use App\Repositories\lifeStyle\LifeStyleRepositoryInterface;
use App\Repositories\NewsPortal\NewsPortalRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class BaseUserController extends Controller
{


    public function register(Request $request)
    {
        $value = new User();
        $value->name = $request['name'];
        $value->email = $request['email'];
        $value->password = Hash::make($request['password']);
        $value->save();

        return $value;
    }

    public function userLoginCheck(Request $request)
    {
        if(Auth::attempt($request->only('email','password'))) {

            return redirect()->route('dashboard');
        }
        else
        {
            return redirect('/login')->withErrors([
                'email' => 'Credentials do not match',
            ]);
        }
    }

    public function LoginPageShow()
    {
        if (!Auth::user())
        {
            return view('login');
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    public function logoutUser(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
