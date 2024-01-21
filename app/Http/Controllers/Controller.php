<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use ValidatesRequests, AuthorizesRequests;

    public function main()
    {
        return view('main');
    }

    public function shop()
    {
        return view('shop');
    }

    public function about()
    {
        return view('about');
    }

    public function feedback()
    {
        return view('feedback');
    }

    public function loginForm()
    {
        return view('login');
    }

    public function accountinfo()
    {
        return view('accountinfo');
    }

    public function resetPassForm()
    {
        return view('resetpass');
    }

    public function registerform()
    {
        return view('register');
    }

    public function resetCodeForm()
    {
        return view('resetcode');
    }

    public function verify2FA()
    {
        if (Session::get('email') != null) {
            $link = URL::temporarySignedRoute(
                '2factor',
                now()->addMinutes(5),
                ['email' => Session::get('email')]
            );
            return redirect($link);
        } else {
            return redirect('/login');
        }
    }

    public function show2faForm()
    {
        return view('2facodeForm');
    }
}
