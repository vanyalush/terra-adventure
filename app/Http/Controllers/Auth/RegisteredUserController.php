<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'last_name'  => ['required', 'string', 'max:255'],
            'name'       => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'phone'      => ['required', 'string', 'max:20'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'last_name.required' => 'Введите фамилию',
            'name.required'      => 'Введите имя',
            'phone.required'     => 'Введите номер телефона',
            'email.required'     => 'Введите email',
            'email.unique'       => 'Этот email уже зарегистрирован',
            'password.required'  => 'Введите пароль',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = User::create([
            'last_name'   => $request->last_name,
            'name'        => $request->name,
            'middle_name' => $request->middle_name,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home'));
    }
}
