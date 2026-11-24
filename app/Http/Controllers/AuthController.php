<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('home');
        }

        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Proses autentikasi login (Mendukung Login via Username/Nama maupun Email - Case-Insensitive)
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginInput = trim($request->input('username'));
        $password = $request->input('password');
        $remember = $request->has('remember');

        // Cari user berdasarkan username (kolom name) ATAU email (tidak sensitif huruf besar/kecil)
        $user = User::whereRaw('LOWER(name) = ?', [strtolower($loginInput)])
            ->orWhereRaw('LOWER(email) = ?', [strtolower($loginInput)])
            ->first();

        // Verifikasi password dan login
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }

            return redirect()->intended(route('home'))->with('success', 'Login berhasil! Selamat berbelanja.');
        }

        return back()->withErrors([
            'username' => 'Username/email atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Tampilkan form registrasi
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return response()
            ->view('auth.register')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Proses registrasi user baru
     */
    public function register(Request $request)
    {
        // =========================================================================
        // # JIKA INGIN MENGUBAH ATURAN REGISTRASI (PASSWORD / NIK / NO HP):
        // 1. Password gampang (tanpa regex simbol/huruf besar):
        //    Ganti 'password' => ['required', 'string', 'min:6', 'confirmed']
        // 2. Hilangkan NIK: Hapus baris 'nik' => [...] di bawah ini dan di array create.
        // 3. Ubah panjang nama: Ubah min:3 dan max:50.
        // =========================================================================
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'nik' => ['nullable', 'regex:/^[0-9]{16}$/'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^a-zA-Z0-9]/',
                'confirmed',
            ],
            'phone' => ['nullable', 'regex:/^(\+?[0-9]{10,15})$/'],
            'address' => 'nullable|string',
        ], [
            'name.required' => 'Nama lengkap / Username wajib diisi.',
            'name.min' => 'Nama / Username minimal 3 karakter.',
            'name.max' => 'Nama / Username tidak boleh lebih dari 50 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'nik.regex' => 'NIK harus berupa angka tepat 16 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung kombinasi huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan simbol (@#$%).',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'phone.regex' => 'Nomor HP/WhatsApp harus berupa angka valid (10-15 digit) dan boleh menggunakan awalan + (contoh: 08... atau +62...).',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Pendaftaran akun berhasil! Selamat datang di BookStore.');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil logout.');
    }
}
