<?php

namespace zedsh\tower\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use zedsh\tower\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{

    public function show()
    {
        return view('tower::pages.registration.index');
    }

    public function submit(RegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->only('name','email','password'));
        $user->password = Hash::make($user->password);
        $user->saveOrFail();

        return redirect(route('tower::innate::login'));
    }
}
