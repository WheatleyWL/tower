<?php

namespace zedsh\tower\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use zedsh\tower\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    public function show()
    {
        return view('tower::pages.authorization.index');
    }

    public function submit(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email','password'), !empty($request->only('remember')))) {
            return redirect()->route('tower::innate::home');
        }

        return redirect()->back()->withErrors([
            'msg'=>'Такого пользователя не существует.'
        ]);
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('tower::innate::login');
    }
}
