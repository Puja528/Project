<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        ]);

        $username = $request->username;
        $email = $request->email;
        $password = $request->password;

        // VALIDASI CREDENTIAL MANUAL
        $errors = [];
        $userType = null;
        $userData = null;

        foreach ($this->users as $type => $user) {
            if (
                $username === $user['username'] &&
                $email === $user['email'] &&
                $password === $user['password']
            ) {
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

            return redirect()->route('login.index')
                ->withErrors($errors)
                ->withInput();
        }

        // SIMPAN USER KE DB JIKA BELUM ADA
        $userDB = User::where('email', $email)->first();

        if (!$userDB) {
            $userDB = User::create([
                'name' => $username,
                'email' => $email,
                'password' => bcrypt('passworddummy'),
                'type' => $userType,
                'status' => 1,
            ]);
        }

        // LOGIN KE LARAVEL AUTH
        Auth::login($userDB);

        // SIMPAN DATA KE SESSION
        session([
            'logged_in' => true,
            'user_id' => $userDB->id,   // ← FIX UTAMA
            'username' => $username,
            'user_type' => $userType,
            'user_data' => $userData,
        ]);

        // Redirect sesuai role
        switch ($userType) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Login Admin Berhasil!');

            case 'advance':
                return redirect()->route('home.advance')
                    ->with('success', 'Login Advance Berhasil! Selamat datang ' . $username);

            case 'standard':
            default:
                return redirect()->route('home.standard')
                    ->with('success', 'Login Berhasil! Selamat datang ' . $username);
        }
    }
}
