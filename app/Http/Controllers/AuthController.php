<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'nullable|in:client,organization'
        ]);

        $roleId = ($data['role'] ?? 'client') === 'organization' ? Role::ORGANIZATION : Role::CLIENT;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId,
        ]);

        Auth::login($user);

        if ($roleId === Role::ORGANIZATION) {
            return redirect()->route('organization.dashboard')->with('success', 'Добро пожаловать! Заполните данные вашей организации.');
        }

        return redirect()->route('client.dashboard')->with('success', 'Добро пожаловать!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->isOrganization()) {
                return redirect()->intended('/organization/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Неверный email или пароль'])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Вы вышли из системы');
    }
}
