<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $users = [
        'standard' => [
            'email' => 'standard@gmail.com',
            'username' => 'standard123',
            'password' => 'Standard123',
            'type' => 'standard',
        ],
        'advance' => [
            'email' => 'advance@gmail.com',
            'username' => 'advance123',
            'password' => 'Advance123',
            'type' => 'advance',
        ],
        'admin' => [
            'email' => 'admin@gmail.com',
            'username' => 'admin123',
            'password' => 'Admin123',
            'type' => 'admin',
        ]
    ];

    public function index()
    {
        if (session('logged_in')) {
            if (session('user_type') === 'standard') {
                return redirect()->route('home.standard');
            } else if (session('user_type') === 'advance') {
                return redirect()->route('home.advance');
            } else if (session('user_type') === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf kecil, huruf besar, dan angka',
        ]);

        $username = $request->username;
        $email = $request->email;
        $password = $request->password;

        // Cek kredensial untuk semua tipe user
        $errors = [];
        $userType = null;
        $userData = null;

        foreach ($this->users as $type => $user) {
            if ($username === $user['username'] &&
                $email === $user['email'] &&
                $password === $user['password']) {
                $userType = $type;
                $userData = $user;
                break;
            }
        }

        if (!$userType) {
            $validUsernames = implode(', ', array_column($this->users, 'username'));
            $validEmails = implode(', ', array_column($this->users, 'email'));

            if (!in_array($username, array_column($this->users, 'username'))) {
                $errors['username'] = ['Username harus: ' . $validUsernames];
            }
            if (!in_array($email, array_column($this->users, 'email'))) {
                $errors['email'] = ['Email harus: ' . $validEmails];
            }
            if (!in_array($password, array_column($this->users, 'password'))) {
                $errors['password'] = ['Password salah'];
            }
        }

        if (!empty($errors)) {
            return redirect()->route('login.index')
                ->withErrors($errors)
                ->withInput();
        }

        // Login berhasil - redirect berdasarkan tipe user
        session([
            'logged_in' => true,
            'username' => $username,
            'user_type' => $userType,
            'user_data' => $userData,
        ]);

        // Redirect berdasarkan tipe user
        switch ($userType) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Login Admin Berhasil!');
            case 'advance':
                return redirect()->route('home.advance')->with('success', 'Login Advance Berhasil! Selamat datang ' . $username);
            case 'standard':
            default:
                return redirect()->route('home.standard')->with('success', 'Login Berhasil! Selamat datang ' . $username);
        }
    }
}
