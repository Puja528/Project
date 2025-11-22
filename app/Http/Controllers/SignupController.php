<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index()
    {
        return view("pages.auth.signup");
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email'    => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'password.min'   => 'Password harus memiliki minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf kecil, huruf besar, dan angka',
        ]);

        // Simpan data user ke session (sementara tanpa database)
        session([
            'user' => [
                'username' => $request->username,
                'email'    => $request->email,
                'password' => $request->password,
            ],
        ]);

        return redirect()->route('login.index')->with('success', 'Sign up berhasil! Silakan login.');
    }
}