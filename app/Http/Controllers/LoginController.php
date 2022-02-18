<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('page.auth.login');
    }

    public function store(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->with('login_fail', 'Email / Password is Wrongl');
    }
}
